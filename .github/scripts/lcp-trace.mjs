import fs from 'node:fs/promises';
import assert from 'node:assert/strict';
import { createHash } from 'node:crypto';
import { chromium } from '/tmp/bookorgo-trace/node_modules/playwright/index.mjs';
import { routes, conditions, categories, sanitize, validateCapture, validateSuite } from './lcp-trace-utils.mjs';

const output = 'site/test-results/lcp-trace';
await fs.mkdir(output, { recursive: true });
const previous = JSON.parse(await fs.readFile('docs/evidence/P1-05i-performance-comparison.json', 'utf8'));
const rows = [], failures = [];
const profile = { viewport: { width: 412, height: 823 }, deviceScaleFactor: 1.75, isMobile: true, hasTouch: true, locale: 'en-US', serviceWorkers: 'block', userAgent: 'Mozilla/5.0 (Linux; Android 11; moto g power) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36' };
const write = (name, data) => fs.writeFile(`${output}/${name}`, JSON.stringify(sanitize(data), null, 2));

function observe() {
    const data = window.__bookorgoTrace = { visibility: [{ at: performance.now(), state: document.visibilityState }], lcp: [], longTasks: [], errors: [] };
    document.addEventListener('visibilitychange', () => data.visibility.push({ at: performance.now(), state: document.visibilityState }));
    for (const type of ['largest-contentful-paint', 'longtask']) {
        try {
            new PerformanceObserver(list => {
                for (const e of list.getEntries()) {
                    if (type === 'longtask') data.longTasks.push({ startTime: e.startTime, duration: e.duration, name: e.name });
                    else { const el = e.element; data.lcp.push({ startTime: e.startTime, renderTime: e.renderTime, loadTime: e.loadTime, size: e.size, tag: el?.tagName ?? null, id: el?.id ?? null, classes: el?.className ?? null, currentSrc: el instanceof HTMLImageElement ? el.currentSrc : null }); }
                }
            }).observe({ type, buffered: true });
        } catch (e) { data.errors.push(`${type}: ${e.message}`); }
    }
}

for (const [name, path] of routes) {
    // A fresh browser/context per route; only the second visit shares HTTP cache/connections.
    const browser = await chromium.launch({ headless: true, args: ['--disable-dev-shm-usage'] });
    const context = await browser.newContext(profile);
    await context.addInitScript(observe);
    const page = await context.newPage();
    const client = await context.newCDPSession(page);
    await client.send('Network.enable');
    await client.send('Network.clearBrowserCache');
    await client.send('Network.setCacheDisabled', { cacheDisabled: false });
    let network = [];
    client.on('Network.requestWillBeSent', e => network.push({ method: 'Network.requestWillBeSent', requestId: e.requestId, timestamp: e.timestamp, wallTime: e.wallTime, type: e.type, url: e.request.url, requestMethod: e.request.method, initialPriority: e.request.initialPriority, initiatorType: e.initiator.type }));
    client.on('Network.responseReceived', e => network.push({ method: 'Network.responseReceived', requestId: e.requestId, timestamp: e.timestamp, type: e.type, url: e.response.url, status: e.response.status, protocol: e.response.protocol, timing: e.response.timing ?? null, fromDiskCache: e.response.fromDiskCache ?? false, fromServiceWorker: e.response.fromServiceWorker ?? false, connectionReused: e.response.connectionReused, encodedDataLength: e.response.encodedDataLength }));
    client.on('Network.requestServedFromCache', e => network.push({ method: 'Network.requestServedFromCache', requestId: e.requestId }));
    client.on('Network.loadingFinished', e => network.push({ method: 'Network.loadingFinished', requestId: e.requestId, timestamp: e.timestamp, encodedDataLength: e.encodedDataLength }));
    client.on('Network.loadingFailed', e => network.push({ method: 'Network.loadingFailed', requestId: e.requestId, timestamp: e.timestamp, errorText: e.errorText, type: e.type }));
    try {
        for (const condition of conditions) {
            const row = { page: name, condition, browser: browser.version(), capturedAt: new Date().toISOString(), errors: [] };
            network = [];
            let tracing = false;
            try {
                await page.bringToFront();
                await browser.startTracing(page, { screenshots: false, categories }); tracing = true;
                const response = await page.goto(`https://bookorgo.com${path}`, { waitUntil: 'load', timeout: 30000 });
                row.status = response.status(); row.finalUrl = page.url();
                // Fixed observation window, not a readiness retry or rerun-until-green loop.
                await page.waitForTimeout(2000);
                row.robots = await page.locator('meta[name="robots"]').getAttribute('content');
                row.measurements = await page.evaluate(() => ({ ...window.__bookorgoTrace, navigation: performance.getEntriesByType('navigation')[0].toJSON(), paints: performance.getEntriesByType('paint').map(e => e.toJSON()), resources: performance.getEntriesByType('resource').map(e => e.toJSON()), visibilityAtEnd: document.visibilityState, fontStatus: document.fonts.status, images: [...document.images].filter(el => { const r = el.getBoundingClientRect(); return r.width && r.height && r.top < innerHeight && r.bottom > 0; }).map(el => ({ currentSrc: el.currentSrc, width: el.width, height: el.height, naturalWidth: el.naturalWidth, naturalHeight: el.naturalHeight, loading: el.loading, fetchPriority: el.fetchPriority })), assets: [...document.querySelectorAll('[src], [href]')].flatMap(el => ['src', 'href'].map(attr => el.getAttribute(attr)).filter(v => v?.includes('/build/assets/'))).sort() }));
                row.assets = row.measurements.assets;
                const expected = previous.after.find(x => x.page === name)?.assets;
                assert.ok(expected?.length, 'Preserved release asset fingerprint exists');
                assert.deepEqual(row.assets, expected, 'Assets match preserved verified-release observation');
                assert.deepEqual(row.measurements.errors, [], 'Observers installed');
            } catch (error) { row.errors.push(error.message); }
            finally {
                row.network = network;
                if (tracing) {
                    try {
                        const trace = sanitize(JSON.parse((await browser.stopTracing()).toString()));
                        const bytes = JSON.stringify(trace);
                        row.trace = { file: `${name}-${condition}.trace.json`, sha256: createHash('sha256').update(bytes).digest('hex'), eventCount: trace.traceEvents.length };
                        await fs.writeFile(`${output}/${row.trace.file}`, bytes);
                        validateCapture(row, trace);
                    } catch (error) { row.errors.push(error.message); }
                }
                rows.push(row);
                await write(`${name}-${condition}.json`, row);
                console.log(JSON.stringify({ page: name, condition, errors: row.errors, traceEvents: row.trace?.eventCount, lcp: row.measurements?.lcp }));
            }
            if (row.status === 401 || row.status === 403) throw new Error('Access wall: stop remaining navigations');
        }
    } finally { await context.close(); await browser.close(); }
}
try { validateSuite(rows); } catch (error) { failures.push(error.message); }
await write('summary.json', { task: 'P1-05k', sourceRevision: process.env.GITHUB_SHA, capturedAt: new Date().toISOString(), mode: 'READ_ONLY_OBSERVED_TRACE_NOT_LIGHTHOUSE', expectedLiveRevision: previous.expectedLiveRevision, profile, categories, navigationBudget: 6, rows, failures, limitations: ['Unthrottled observed Chrome timings; not simulated Lighthouse or field p75/INP, not comparable speed deltas.', 'One cold/warm pair per route on shared CI. Warm means same session; actual cache hits recorded, CDN/origin cache state not controlled.', 'Fixed 2-second post-load capture. Instrumentation adds overhead; traces cannot retroactively prove the prior outlier cause.', 'No deployment, application/database writes or interactions. Existing passive site telemetry may run.', 'URL query/fragment and credential-like header/body fields removed from traces and derived evidence. No screenshots or authenticated session.', 'Exact design acceptance and existing P0 operational gaps remain open.'] });
if (failures.length) process.exitCode = 1;
