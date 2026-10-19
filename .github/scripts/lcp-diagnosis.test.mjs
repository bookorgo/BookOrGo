import test from 'node:test';
import assert from 'node:assert/strict';
import { extract, compareReports, routes, slots } from './lcp-diagnosis.mjs';

function fixture(slot = slots[0]) {
    return { finalDisplayedUrl: `https://bookorgo.com${routes[slot.page]}`, lighthouseVersion: '12.8.2', environment: { hostUserAgent: 'Chromium141' },
        configSettings: { formFactor: slot.profile, throttlingMethod: 'simulate' }, audits: {
            metrics: { details: { items: [{ observedFirstContentfulPaint: 300, observedLargestContentfulPaint: 400, observedDomContentLoaded: 290, observedLoad: 500 }] } },
            'largest-contentful-paint': { numericValue: 2600 }, 'total-blocking-time': { numericValue: 0 },
            'lcp-breakdown-insight': { details: { items: [{ type: 'table', items: [{ subpart: 'timeToFirstByte', duration: 200 }, { subpart: 'elementRenderDelay', duration: 200 }] }, { type: 'node', selector: 'h1' }] } },
            'network-requests': { details: { items: [{ url: 'https://bookorgo.com/image.webp?secret=value#x', resourceType: 'Image', networkRequestTime: 20, networkEndTime: 90, resourceSize: 50, transferSize: 70 }] } },
            'long-tasks': { details: { items: [{ startTime: 800, duration: 100 }] } },
        }, runWarnings: [] };
}
const collection = () => slots.map(slot => extract(fixture(slot), slot, 'fixture'));
test('keeps observed and simulated LCP separate, including signed paint delay', () => {
    const row = extract(fixture(), slots[0], 'fixture');
    assert.equal(row.simulatedLcpMs, 2600); assert.equal(row.observed.observedLargestContentfulPaint, 400);
    assert.equal(row.firstPaintAfterLoadMs, -200); assert.equal(row.requests[0].durationMs, 70);
});
test('strips request query/hash and makes no currentSrc assertion', () => {
    const row = extract(fixture(), slots[0], 'fixture');
    assert.equal(row.requests[0].url, 'https://bookorgo.com/image.webp'); assert.equal(row.currentSrc, undefined);
});
test('zero TBT retains long tasks and null discovery is not a passed image check', () => {
    const row = extract(fixture(), slots[0], 'fixture');
    assert.equal(row.simulatedTbtMs, 0); assert.equal(row.longTasks.length, 1); assert.equal(row.discovery, null);
});
test('missing measurements, failed audits, wrong route/profile and chronology fail closed', () => {
    for (const mutate of [r => r.runtimeError = { code: 'FAILED' }, r => r.finalDisplayedUrl = 'https://other.example/',
        r => r.configSettings.formFactor = 'desktop', r => r.configSettings.throttlingMethod = 'provided',
        r => r.audits.metrics.details.items[0].observedLargestContentfulPaint = null,
        r => r.audits['network-requests'].details.items[0].networkEndTime = 0,
        r => r.audits['lcp-breakdown-insight'].details.items[1].selector = null]) {
        const report = fixture(); mutate(report); assert.throws(() => extract(report, slots[0], 'fixture'));
    }
});
test('requires 48 complete unique reports', () => {
    const rows = collection(); assert.equal(compareReports(rows, rows).reportCount, 48);
    assert.throws(() => compareReports(rows.slice(1), rows));
    const duplicate = structuredClone(rows); duplicate[0] = duplicate[1]; assert.throws(() => compareReports(rows, duplicate));
});
test('methodology mismatch cannot pass comparison', () => {
    for (const mutate of [r => r.methodology.browser = 'other', r => r.methodology.lighthouseVersion = 'other', r => r.methodology.settings.throttlingMethod = 'other']) {
        const before = collection(), after = structuredClone(before); mutate(after[0]); assert.throws(() => compareReports(before, after));
    }
});
test('regressions and observed improvements coexist without being discarded', () => {
    const before = collection(), after = structuredClone(before); after[0].simulatedLcpMs += 500; after[0].observed.observedLargestContentfulPaint -= 50;
    const result = compareReports(before, after).comparisons[0]; assert.equal(result.simulatedLcpDeltaMs, 500); assert.equal(result.observedLcpDeltaMs, -50);
});
