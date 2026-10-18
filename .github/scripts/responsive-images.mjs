import { chromium, firefox, webkit } from '/tmp/bookorgo-quality/node_modules/playwright/index.mjs';
import fs from 'node:fs/promises';
import assert from 'node:assert/strict';

const origin = process.env.BOOKORGO_AUDIT_ORIGIN || 'http://127.0.0.1:8000';
assert.ok(['http://127.0.0.1:8000', 'https://bookorgo.com'].includes(origin), 'explicit source/live origin allowlist');
const manifest = JSON.parse(await fs.readFile('site/resources/images/responsive/manifest.json', 'utf8'));
const vite = JSON.parse(await fs.readFile('site/public/build/manifest.json', 'utf8'));
const byUrl = new Map(Object.values(manifest).flatMap(photo => photo.variants.map(v => [new URL(`/build/${vite[v.path].file}`, origin).href, { ...v, original: photo.variants.at(-1), source: photo }])));
const output = 'site/test-results/quality';
await fs.mkdir(output, { recursive: true });
const rows = [], failures = [];
// Poll from Node: image.decode() can stay pending in a no-script browser context.
// Every wait is bounded and every case is persisted before starting the next.
async function waitForPhoto(photo, fallback = false) {
    await photo.scrollIntoViewIfNeeded();
    const deadline = Date.now() + 10000;
    do {
        if (await photo.evaluate((image, original) => image.complete && image.naturalWidth > 0 && (!original || image.currentSrc === image.src), fallback)) return;
        await new Promise(resolve => setTimeout(resolve, 100));
    } while (Date.now() < deadline);
    throw new Error(`Image load timed out (${fallback ? 'original fallback' : 'responsive'})`);
}
const pages = [
    { name: 'home', path: '/', count: 25 },
    { name: 'listing', path: '/search', count: 9 },
    { name: 'detail', path: '/cruises/dubai/sample-creek-cruise', count: 10 },
];
const save = () => fs.writeFile(`${output}/responsive-images.json`, JSON.stringify({ task: 'P1-05h', sourceRevision: process.env.GITHUB_SHA || null, origin, mode: origin === 'https://bookorgo.com' ? 'LIVE_READ_ONLY' : 'CI_SOURCE', checkedAt: new Date().toISOString(), rows, failures, scope: 'Unique selected visible-image file sizes, not network transfer or LCP; no-JS DPR1/2, original fallback and geometry/crop checks. Hidden mobile hero excluded from visible-image byte accounting.' }, null, 2));
for (const [engine, type] of Object.entries({ chromium, firefox, webkit })) {
    const browser = await type.launch();
    try {
        for (const target of pages) for (const width of [320, 390, 768, 1440]) for (const dpr of [1, 2]) {
            const context = await browser.newContext({ viewport: { width, height: 1000 }, deviceScaleFactor: dpr, javaScriptEnabled: false });
            const page = await context.newPage();
            page.setDefaultTimeout(15000);
            page.setDefaultNavigationTimeout(20000);
            let phase = 'navigation';
            console.log(JSON.stringify({ event: 'start', template: target.name, engine, width, dpr }));
            try {
                await page.goto(`${origin}${target.path}`);
                assert.equal(await page.locator('img.destination-photo').count(), target.count);
                assert.equal(await page.locator('img.destination-photo[srcset][sizes]').count(), target.count);
                const photos = page.locator('img.destination-photo:visible');
                assert.equal(await photos.count(), target.count - (target.name === 'home' && width <= 720 ? 1 : 0));
                phase = 'responsive load';
                for (const photo of await photos.all()) await waitForPhoto(photo);
                const capture = () => photos.evaluateAll(images => images.map(image => {
                    const r = image.getBoundingClientRect(), css = getComputedStyle(image);
                    return { currentSrc: image.currentSrc, src: image.src, width: r.width, height: r.height,
                        left: r.left, top: r.top + scrollY, fit: css.objectFit, position: css.objectPosition,
                        complete: image.complete && image.naturalWidth > 0 };
                }));
                const responsive = await capture();
                assert.ok(responsive.every(image => image.complete && image.fit === 'cover'));
                const selected = responsive.map(image => {
                    const variant = byUrl.get(image.currentSrc);
                    assert.ok(variant, 'selected candidate is a verified build asset');
                    const required = Math.min(variant.source.width, Math.max(image.width, image.height * variant.source.width / variant.source.height) * dpr);
                    // Browser candidate selection may round at boundaries; no gross undersizing.
                    assert.ok(variant.width >= required * .9, `candidate resolution ${variant.width} vs ${required}`);
                    return variant;
                });
                const unique = values => [...new Map(values.map(v => [v.path, v])).values()];
                const chosenBytes = unique(selected).reduce((sum, v) => sum + v.bytes, 0);
                const originalBytes = unique(selected.map(v => v.original)).reduce((sum, v) => sum + v.bytes, 0);
                console.log(JSON.stringify({ event: 'selection', template: target.name, engine, width, dpr, chosenBytes, originalBytes, selected: unique(selected).map(v => ({ path: v.path, width: v.width, bytes: v.bytes })) }));
                assert.ok(chosenBytes < originalBytes, 'smaller unique selected image bytes');
                if (dpr === 1 && (width === 390 || width === 1440) && engine === 'chromium') {
                    await page.evaluate(() => scrollTo(0, 0));
                    await page.screenshot({ path: `${output}/responsive-${target.name}-${width}.png`, fullPage: true });
                }
                // Remove responsive attributes to render exact original fallback and compare geometry/crop policy.
                phase = 'original fallback';
                await photos.evaluateAll(images => images.forEach(image => { image.removeAttribute('srcset'); image.removeAttribute('sizes'); }));
                for (const photo of await photos.all()) await waitForPhoto(photo, true);
                const fallback = await capture();
                for (let i = 0; i < fallback.length; i++) {
                    assert.equal(fallback[i].currentSrc, fallback[i].src);
                    for (const key of ['width', 'height', 'left', 'top', 'fit', 'position']) assert.equal(fallback[i][key], responsive[i][key], `unchanged ${key}`);
                }
                assert.match(await page.locator('meta[name="robots"]').getAttribute('content'), /noindex/);
                assert.equal(await page.locator('img[fetchpriority="high"]').count(), 1);
                assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth + 1));
                rows.push({ template: target.name, path: target.path, engine, width, dpr, javaScriptEnabled: false, visiblePhotos: responsive.length, chosenBytes, originalBytes, reduction: 1 - chosenBytes / originalBytes, selected: unique(selected).map(({ path, width, bytes }) => ({ path, width, bytes })), geometryAndCropUnchanged: true });
            } catch (error) { failures.push({ template: target.name, engine, width, dpr, phase, error: error.message }); }
            finally {
                await context.close();
                await save();
                console.log(JSON.stringify({ event: 'finished', template: target.name, engine, width, dpr, passed: rows.length, failures }));
            }
        }
    } finally { await browser.close(); }
}
await save();
console.log(JSON.stringify({ rows: rows.length, failures }));
if (failures.length) process.exitCode = 1;
