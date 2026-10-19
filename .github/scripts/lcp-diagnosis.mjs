import assert from 'node:assert/strict';
import fs from 'node:fs/promises';
import path from 'node:path';
import { createHash } from 'node:crypto';
import { pathToFileURL } from 'node:url';

export const routes = { home: '/', listing: '/search', detail: '/cruises/dubai/sample-creek-cruise', article: '/blog/sample-first-visit-planning' };
export const slots = ['mobile', 'desktop'].flatMap(profile => Object.keys(routes).flatMap(page => [1, 2, 3].map(repeat => ({ profile, page, repeat, name: `${profile}-${page}-${repeat}` }))));
const finite = (value, name) => { assert.ok(Number.isFinite(value) && value >= 0, `Missing/invalid ${name}`); return value; };
const cleanUrl = value => { const url = new URL(value); assert.equal(url.protocol, 'https:'); url.search = ''; url.hash = ''; return url.href; };

export function extract(lhr, slot, sha256) {
    assert.ok(!lhr.runtimeError, 'No runtime error');
    assert.equal(lhr.finalDisplayedUrl, `https://bookorgo.com${routes[slot.page]}`, 'Expected public route');
    assert.equal(lhr.configSettings.formFactor, slot.profile, 'Expected profile');
    assert.equal(lhr.configSettings.throttlingMethod, 'simulate', 'Simulated lab mode');
    const audits = lhr.audits, metrics = audits.metrics.details.items[0];
    const breakdown = audits['lcp-breakdown-insight'].details.items;
    const node = breakdown.find(item => item.type === 'node');
    assert.ok(node?.selector, 'LCP node required');
    const phases = Object.fromEntries(breakdown[0].items.map(item => [item.subpart, finite(item.duration, item.subpart)]));
    assert.ok('timeToFirstByte' in phases && 'elementRenderDelay' in phases, 'Observed phases required');
    const requests = audits['network-requests'].details.items.map(item => {
        const startMs = finite(item.networkRequestTime, 'request start'), endMs = finite(item.networkEndTime, 'request end');
        assert.ok(endMs >= startMs, 'Request chronology');
        return { url: cleanUrl(item.url), type: item.resourceType, startMs, endMs, durationMs: endMs - startMs,
            resourceBytes: finite(item.resourceSize, 'resource bytes'), transferBytes: finite(item.transferSize, 'transfer bytes'), priority: item.priority, protocol: item.protocol };
    });
    const observed = Object.fromEntries(['observedFirstContentfulPaint', 'observedLargestContentfulPaint', 'observedDomContentLoaded', 'observedLoad'].map(key => [key, finite(metrics[key], key)]));
    return { ...slot, reportSha256: sha256, fetchTime: lhr.fetchTime,
        methodology: { lighthouseVersion: lhr.lighthouseVersion, browser: lhr.environment.hostUserAgent, settings: lhr.configSettings },
        simulatedLcpMs: finite(audits['largest-contentful-paint'].numericValue, 'simulated LCP'),
        simulatedTbtMs: finite(audits['total-blocking-time'].numericValue, 'TBT'),
        observed, observedPhasesMs: phases, lcpNode: { selector: node.selector, bounds: node.boundingRect },
        discovery: audits['lcp-discovery-insight']?.details?.items?.find(item => item.type === 'checklist')?.items ?? null,
        requests, longTasks: audits['long-tasks']?.details?.items ?? null, warnings: lhr.runWarnings ?? [],
        firstPaintAfterLoadMs: observed.observedFirstContentfulPaint - observed.observedLoad };
}

export function compareReports(before, after) {
    for (const rows of [before, after]) {
        assert.equal(rows.length, slots.length, '24 reports required per collection');
        assert.deepEqual(rows.map(row => row.name).sort(), slots.map(slot => slot.name).sort(), 'Unique complete slots');
    }
    const comparisons = slots.map(slot => {
        const previous = before.find(row => row.name === slot.name), current = after.find(row => row.name === slot.name);
        assert.deepEqual(previous.methodology, current.methodology, 'Matching browser/Lighthouse/settings');
        return { name: slot.name, simulatedLcpDeltaMs: current.simulatedLcpMs - previous.simulatedLcpMs,
            observedLcpDeltaMs: current.observed.observedLargestContentfulPaint - previous.observed.observedLargestContentfulPaint,
            sameLcpSelector: previous.lcpNode.selector === current.lcpNode.selector };
    });
    return { task: 'P1-05j', mode: 'OFFLINE_EXISTING_REPORT_DIAGNOSIS', reportCount: before.length + after.length, before, after, comparisons,
        limitations: ['No new navigation, field data, deployment or timing measurement. Original P1-05i target misses remain unchanged.',
            'Observed trace timing and simulated Lighthouse timing are distinct; neither is field p75.',
            'Request duration includes request/response waiting and transfer; it does not identify origin, CDN, cache or congestion as the cause.',
            'Network request presence does not prove which element selected it; no currentSrc is inferred from fallback src.',
            'Raw Lighthouse reports lack full trace/devtools event streams and browser visibility evidence; heading paint delay cause remains unresolved.',
            'TBT=0 does not imply no long tasks: retain long-task diagnostics separately.'] };
}

export async function readCollection(directory) {
    return Promise.all(slots.map(async slot => {
        const bytes = await fs.readFile(path.join(directory, `${slot.name}.json`));
        return extract(JSON.parse(bytes), slot, createHash('sha256').update(bytes).digest('hex'));
    }));
}

if (process.argv[1] && import.meta.url === pathToFileURL(process.argv[1]).href) {
    assert.equal(process.argv.length, 4, 'Usage: node lcp-diagnosis.mjs BASELINE_REPORT_DIR CURRENT_REPORT_DIR');
    const [before, after] = await Promise.all(process.argv.slice(2).map(readCollection));
    console.log(JSON.stringify(compareReports(before, after), null, 2));
}
