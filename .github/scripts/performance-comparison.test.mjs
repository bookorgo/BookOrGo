import test from 'node:test';
import assert from 'node:assert/strict';
import fs from 'node:fs';
import { compare, normalize } from './performance-comparison.mjs';
const baseline = normalize(JSON.parse(fs.readFileSync('docs/evidence/P1-05d-performance-baseline.json', 'utf8')));
test('identity comparison retains all ranges including CLS outlier', () => {
    const result = compare(baseline, structuredClone(baseline));
    assert.equal(result.rows.length, 8);
    assert.ok(result.rows.every(row => row.metrics.lcpMs.medianDelta === 0));
    assert.equal(result.rows.find(row => row.profile === 'mobile' && row.page === 'listing').everyObservedClsWithin01, false);
});
test('changed and incomplete measurement methods cannot pass comparison', () => {
    for (const mutate of [r => r.rows.pop(), r => r.failures.push('failed'),
        r => r.rows[0].lighthouseVersion = 'other', r => r.rows[0].environment.hostUserAgent = 'other',
        r => r.rows[0].configSettings.throttlingMethod = 'provided',
        r => r.rows[0].repeat = 2, r => r.rows[0].lcpMs = null]) {
        const current = structuredClone(baseline); mutate(current);
        assert.throws(() => compare(baseline, current));
    }
});
test('signed changes are reported without discarding regressions', () => {
    const current = structuredClone(baseline);
    for (const row of current.rows) row.lcpMs += 500;
    assert.ok(compare(baseline, current).rows.every(row => Math.abs(row.metrics.lcpMs.medianDelta - 500) < 1e-9));
});
