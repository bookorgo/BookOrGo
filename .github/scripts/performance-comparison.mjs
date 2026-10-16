import assert from 'node:assert/strict';
import fs from 'node:fs/promises';
import { pathToFileURL } from 'node:url';
import { summarize } from './performance-summary.mjs';

export function normalize(report) {
    if (report.rows) return report;
    return { ...report, rows: report.runs.map(row => ({ ...row, configSettings: report.profiles[row.profile] })) };
}

export function compare(baseline, current) {
    baseline = normalize(baseline);
    current = normalize(current);
    assert.equal(baseline.origin, current.origin, 'same measured origin');
    for (const report of [baseline, current]) {
        assert.deepEqual(report.failures, [], 'no failed audits');
        assert.equal(report.rows.length, 24, '24 complete measurements');
    }
    const oldGroups = summarize(baseline.rows);
    const newGroups = summarize(current.rows);
    const rows = newGroups.map(group => {
        const key = row => row.profile === group.profile && row.page === group.page;
        const oldRows = baseline.rows.filter(key);
        const newRows = current.rows.filter(key);
        for (const samples of [oldRows, newRows]) {
            assert.deepEqual(samples.map(row => row.repeat).sort(), [1, 2, 3], 'unique repeats');
        }
        // Fail closed if methodology or actual browser changed; do not silently compare.
        for (const row of [...oldRows, ...newRows]) {
            assert.equal(row.lighthouseVersion, oldRows[0].lighthouseVersion, 'same Lighthouse');
            assert.equal(row.environment.hostUserAgent, oldRows[0].environment.hostUserAgent, 'same browser');
            assert.deepEqual(row.configSettings, oldRows[0].configSettings, 'same measurement settings');
        }
        const previous = oldGroups.find(key);
        const metrics = Object.fromEntries(Object.keys(group.metrics).map(metric => [metric, {
            before: previous.metrics[metric], after: group.metrics[metric],
            medianDelta: group.metrics[metric].median - previous.metrics[metric].median,
        }]));
        return { profile: group.profile, page: group.page, metrics,
            everyObservedLcpWithin2500ms: metrics.lcpMs.after.max <= 2500,
            everyObservedClsWithin01: metrics.cls.after.max <= .1 };
    });
    return { task: 'P1-05f', baselineRevision: baseline.expectedLiveRevision,
        currentRevision: current.expectedLiveRevision, baselineMeasuredAt: baseline.measuredAt,
        currentMeasuredAt: current.measuredAt, rows,
        limitations: ['Independent small lab samples on shared CI; differences are observations, not a controlled causal estimate or field p75.',
            'TBT is not INP. Preserve min/max outliers; a median alone does not establish stability.',
            'Release attribution uses deployment logs and stable asset checks, not an asserted runtime revision endpoint.'] };
}

if (process.argv[1] && import.meta.url === pathToFileURL(process.argv[1]).href) {
    const baseline = JSON.parse(await fs.readFile('docs/evidence/P1-05d-performance-baseline.json', 'utf8'));
    const current = JSON.parse(await fs.readFile('site/test-results/performance/summary.json', 'utf8'));
    const result = compare(baseline, current);
    await fs.writeFile('site/test-results/performance/comparison.json', JSON.stringify(result, null, 2));
    console.log(JSON.stringify(result));
}
