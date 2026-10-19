import test from 'node:test';
import assert from 'node:assert/strict';
import { sanitize, validateCapture, validateSuite, routes, conditions } from './lcp-trace-utils.mjs';
const trace = { traceEvents: [{ name: 'largestContentfulPaint::Candidate' }] };
function row(page = 'home', condition = 'cold') { return { page, condition, status: 200, finalUrl: `https://bookorgo.com${routes.find(x => x[0] === page)[1]}`, robots: 'noindex,nofollow', errors: [], assets: ['a.css'], network: [{ method: 'Network.responseReceived', type: 'Document', status: 200 }], measurements: { navigation: { responseStart: 100 }, paints: [{ name: 'first-contentful-paint', startTime: 200 }], visibility: [{ state: 'visible' }], lcp: [{ startTime: 200, currentSrc: page === 'detail' ? 'https://bookorgo.com/build/assets/image.webp' : null }] } }; }
const suite = () => routes.flatMap(([page]) => conditions.map(condition => row(page, condition)));
test('sanitizes nested URLs and drops headers/cookies/body data', () => {
    const safe = sanitize({ headers: { token: 'secret' }, postData: 'secret', nested: [{ url: 'https://u:p@bookorgo.com/x?token=secret#private', cookies: ['secret'] }] });
    assert.deepEqual(safe, { nested: [{ url: 'https://bookorgo.com/x' }] });
});
test('valid capture and exactly six paired navigations pass', () => { for (const r of suite()) validateCapture(r, trace); validateSuite(suite()); });
test('missing trace, LCP or FCP fails closed', () => {
    assert.throws(() => validateCapture(row(), { traceEvents: [] }));
    for (const key of ['lcp', 'paints']) { const r = row(); r.measurements[key] = []; assert.throws(() => validateCapture(r, trace)); }
});
test('HTTP errors, redirects, indexing and hidden documents fail closed', () => {
    for (const mutate of [r => r.status = 403, r => r.finalUrl += 'other', r => r.robots = 'index', r => r.measurements.visibility.push({ state: 'hidden' })]) { const r = row(); mutate(r); assert.throws(() => validateCapture(r, trace)); }
});
test('detail requires measured currentSrc rather than fallback assumptions', () => { const r = row('detail'); r.measurements.lcp[0].currentSrc = null; assert.throws(() => validateCapture(r, trace)); });
test('missing, duplicate and failed navigations are never discarded', () => {
    assert.throws(() => validateSuite(suite().slice(1))); const duplicate = suite(); duplicate[1] = duplicate[0]; assert.throws(() => validateSuite(duplicate)); const failed = suite(); failed[0].errors.push('timeout'); assert.throws(() => validateSuite(failed));
});
test('asset changes fail paired comparison', () => { const r = suite(); r[1].assets = ['changed.css']; assert.throws(() => validateSuite(r)); });
