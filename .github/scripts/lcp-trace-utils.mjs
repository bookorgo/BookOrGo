import assert from 'node:assert/strict';

export const routes = [['home', '/'], ['detail', '/cruises/dubai/sample-creek-cruise'], ['article', '/blog/sample-first-visit-planning']];
export const conditions = ['cold', 'warm'];
export const categories = ['devtools.timeline', 'disabled-by-default-devtools.timeline', 'blink.user_timing', 'loading', 'toplevel', 'latencyInfo'];

// No header values, cookies, query tokens or response bodies belong in public evidence.
export function sanitize(value) {
    if (Array.isArray(value)) return value.map(sanitize);
    if (value && typeof value === 'object') return Object.fromEntries(Object.entries(value).filter(([key]) => !/^(headers|requestHeaders|responseHeaders|cookie|cookies|authorization|postData|postDataEntries)$/i.test(key)).map(([key, item]) => [key, sanitize(item)]));
    if (typeof value === 'string') return value.replace(/https?:\/\/[^\s"<>]+/g, raw => {
        try { const url = new URL(raw); url.search = ''; url.hash = ''; url.username = ''; url.password = ''; return url.href; } catch { return '[invalid-url]'; }
    });
    return value;
}

export function validateCapture(row, trace) {
    assert.equal(row.status, 200, 'HTTP 200');
    assert.equal(row.finalUrl, `https://bookorgo.com${routes.find(([name]) => name === row.page)?.[1]}`, 'Exact route');
    assert.match(row.robots, /noindex/i, 'Draft remains noindex');
    assert.ok(row.measurements.visibility.length > 0 && row.measurements.visibility.every(x => x.state === 'visible'), 'Visible throughout recorded interval');
    assert.ok(Number.isFinite(row.measurements.navigation.responseStart) && row.measurements.navigation.responseStart > 0, 'Navigation timing');
    assert.ok(row.measurements.paints.some(x => x.name === 'first-contentful-paint' && x.startTime > 0), 'FCP observed');
    assert.ok(row.measurements.lcp.length > 0, 'LCP observed');
    assert.ok(trace.traceEvents?.length > 0, 'Trace events retained');
    assert.ok(trace.traceEvents.some(x => /largestContentfulPaint/i.test(x.name)), 'Trace LCP event');
    assert.ok(row.network.some(x => x.method === 'Network.responseReceived' && x.type === 'Document' && x.status === 200), 'Document network evidence');
    if (row.page === 'detail') assert.ok(row.measurements.lcp.some(x => x.currentSrc?.includes('/build/assets/')), 'Actual LCP image currentSrc');
}

export function validateSuite(rows) {
    const expected = routes.flatMap(([page]) => conditions.map(condition => `${page}-${condition}`)).sort();
    assert.deepEqual(rows.map(row => `${row.page}-${row.condition}`).sort(), expected, 'Exactly six unique navigations');
    assert.ok(rows.every(row => row.errors.length === 0), 'All capture checks passed');
    for (const [page] of routes) {
        const pair = rows.filter(row => row.page === page);
        assert.deepEqual(pair[0].assets, pair[1].assets, 'Same built assets across pair');
    }
}
