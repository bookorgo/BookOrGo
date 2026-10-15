import test from 'node:test';
import assert from 'node:assert/strict';
import { distribution, summarize } from './performance-summary.mjs';

test('median retains outlier range and does not sort lexicographically', () => {
    assert.deepEqual(distribution([12000, 900, 2500]), { min: 900, median: 2500, max: 12000 });
});
test('missing, null and nonfinite measurements cannot become a passing baseline', () => {
    for (const values of [[1, 2], [1, null, 3], [1, NaN, 3], [1, Infinity, 3]]) assert.throws(() => distribution(values));
    assert.throws(() => summarize([]));
});
test('performance misses remain visible independently of successful audit execution', () => {
    const rows = ['mobile', 'desktop'].flatMap(profile => ['home', 'listing', 'detail', 'article'].flatMap(page => [1, 2, 3].map(() => ({ profile, page, score: 80, lcpMs: 3000, fcpMs: 2000, tbtMs: 0, cls: .2, speedIndexMs: 4000, transferBytes: 100000 }))));
    const groups = summarize(rows);
    assert.equal(groups.length, 8);
    assert.ok(groups.every(group => !group.labTargets.lcpMedianWithin2500ms && !group.labTargets.clsMedianWithin01));
});
