import fs from 'node:fs/promises';
import assert from 'node:assert/strict';
import { createHash } from 'node:crypto';
import lighthouse from '/tmp/bookorgo-performance/node_modules/lighthouse/core/index.js';
import desktopConfig from '/tmp/bookorgo-performance/node_modules/lighthouse/core/config/desktop-config.js';
import * as chromeLauncher from '/tmp/bookorgo-performance/node_modules/chrome-launcher/dist/index.js';
import { chromium } from '/tmp/bookorgo-performance/node_modules/playwright/index.mjs';
import { summarize } from './performance-summary.mjs';

const origin = 'https://bookorgo.com';
const output = 'site/test-results/performance';
const routes = [['home', '/'], ['listing', '/search'], ['detail', '/cruises/dubai/sample-creek-cruise'], ['article', '/blog/sample-first-visit-planning']];
const rows = [], failures = [];
await fs.mkdir(output, { recursive: true });
async function fingerprint() {
    const pages = [];
    for (const [page, path] of routes) {
        const response = await fetch(origin + path, { redirect: 'error', signal: AbortSignal.timeout(30000) });
        assert.equal(response.status, 200, `${page}: HTTP 200`);
        const html = await response.text();
        assert.match(html, /<meta\s+name="robots"\s+content="[^"]*noindex/i, `${page}: draft remains noindex`);
        const assets = [...html.matchAll(/(?:src|href)="([^"]*\/build\/assets\/[^"?]+)(?:\?[^" ]*)?"/g)].map(match => match[1]).sort();
        assert.ok(assets.length > 0, `${page}: built assets found`);
        pages.push({ page, assets, htmlSha256: createHash('sha256').update(html).digest('hex') });
    }
    return pages;
}
const before = await fingerprint();
for (let repeat = 1; repeat <= 3; repeat++) {
    for (const profile of ['mobile', 'desktop']) {
        for (const [page, path] of routes) {
            const name = `${profile}-${page}-${repeat}`;
            let chrome;
            try {
                // Separate temporary browser profile per run; Lighthouse clears storage/cache.
                chrome = await chromeLauncher.launch({ chromePath: chromium.executablePath(), chromeFlags: ['--headless', '--no-sandbox', '--disable-dev-shm-usage'] });
                const result = await lighthouse(origin + path, { port: chrome.port, logLevel: 'error', output: ['json', 'html'], onlyCategories: ['performance'], throttlingMethod: 'simulate' }, profile === 'desktop' ? desktopConfig : undefined);
                const { lhr } = result;
                await fs.writeFile(`${output}/${name}.json`, result.report[0]);
                await fs.writeFile(`${output}/${name}.html`, result.report[1]);
                assert.ok(!lhr.runtimeError, JSON.stringify(lhr.runtimeError));
                assert.equal(lhr.finalDisplayedUrl, origin + path, 'no unexpected navigation');
                const metric = id => lhr.audits[id]?.numericValue;
                const row = { profile, page, repeat, fetchTime: lhr.fetchTime, lighthouseVersion: lhr.lighthouseVersion, userAgent: lhr.userAgent, environment: lhr.environment, configSettings: lhr.configSettings, score: lhr.categories.performance.score * 100, lcpMs: metric('largest-contentful-paint'), fcpMs: metric('first-contentful-paint'), tbtMs: metric('total-blocking-time'), cls: metric('cumulative-layout-shift'), speedIndexMs: metric('speed-index'), transferBytes: metric('total-byte-weight'), warnings: lhr.runWarnings, diagnostics: Object.values(lhr.audits).filter(audit => typeof audit.score === 'number' && audit.score < 1 && !['metrics', 'diagnostics'].includes(audit.id)).map(audit => ({ id: audit.id, title: audit.title, displayValue: audit.displayValue, numericValue: audit.numericValue, savings: audit.metricSavings, details: audit.details })) };
                rows.push(row);
                console.log(JSON.stringify({ name, score: row.score, lcpMs: row.lcpMs, cls: row.cls, tbtMs: row.tbtMs }));
            } catch (error) {
                failures.push({ name, error: error.message });
                console.error(`${name}: ${error.message}`);
            } finally { if (chrome) await chrome.kill(); }
        }
    }
}
let after;
try {
    after = await fingerprint();
    assert.deepEqual(after.map(({ page, assets }) => ({ page, assets })), before.map(({ page, assets }) => ({ page, assets })), 'live build assets changed during baseline');
} catch (error) { failures.push({ name: 'post-audit-fingerprint', error: error.message }); }
let groups = [];
try { groups = summarize(rows); } catch (error) { failures.push({ name: 'summary', error: error.message }); }
const report = { task: 'P1-05i', mode: 'LIVE_READ_ONLY_LAB', measuredAt: new Date().toISOString(), harnessRevision: process.env.GITHUB_SHA || null, expectedLiveRevision: '0d51ce8d7a29a7a235502aebedd9c02c39943a43', attribution: 'Expected release from verified deployment log; before/after built asset URLs checked. No runtime revision endpoint asserted.', origin, repeats: 3, before, after, rows, groups, failures, limitations: ['Simulated Lighthouse navigation lab measurements on shared CI hardware, not field p75 or physical-device measurements.', 'TBT is a lab diagnostic, not measured INP. Field CWV acceptance remains open.', 'Fresh browser profiles; server/CDN caches may be warm. Browser/version/config captured per run.', 'Read-only page navigation; no forms, database writes, indexing, ads or deployment.', 'A successful workflow means all audits executed, not that all performance targets passed.'] };
await fs.writeFile(`${output}/summary.json`, JSON.stringify(report, null, 2));
const table = ['| Profile | Page | Score median | LCP ms median | CLS median | TBT ms median | Bytes median |', '|---|---|---:|---:|---:|---:|---:|', ...groups.map(group => `| ${group.profile} | ${group.page} | ${group.metrics.score.median.toFixed(0)} | ${group.metrics.lcpMs.median.toFixed(0)} | ${group.metrics.cls.median.toFixed(4)} | ${group.metrics.tbtMs.median.toFixed(0)} | ${group.metrics.transferBytes.median.toFixed(0)} |`)];
const markdown = `# P1-05i post-responsive-image lab baseline\n\n${table.join('\n')}\n\n${report.limitations.join('\n\n')}\n\nExecution failures: ${failures.length}\n`;
await fs.writeFile(`${output}/summary.md`, markdown);
if (process.env.GITHUB_STEP_SUMMARY) await fs.appendFile(process.env.GITHUB_STEP_SUMMARY, markdown);
if (failures.length) process.exitCode = 1;
