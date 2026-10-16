import { chromium, firefox, webkit } from '/tmp/bookorgo-quality/node_modules/playwright/index.mjs';
import fs from 'node:fs/promises';
import assert from 'node:assert/strict';

const origin = process.env.BOOKORGO_AUDIT_ORIGIN || 'https://bookorgo.com';
assert.ok(['https://bookorgo.com', 'http://127.0.0.1:8000'].includes(origin));
const baseline = process.env.BOOKORGO_REPRODUCE_OLD_SHIFT === 'true';
assert.ok(!baseline || origin === 'https://bookorgo.com', 'old behavior reproduction only targets unchanged live baseline');
const output = 'site/test-results/quality';
await fs.mkdir(output, { recursive: true });
const rows = [], failures = [];
for (const [engine, type] of Object.entries({ chromium, firefox, webkit })) {
    const browser = await type.launch();
    try {
        for (const width of [390, 720, 768, 1440]) {
            const context = await browser.newContext({ viewport: { width, height: 1000 } });
            const page = await context.newPage();
            let releaseScripts;
            const gate = new Promise(resolve => { releaseScripts = resolve; });
            let blocked = 0;
            await page.route('**/*', async route => {
                if (route.request().resourceType() === 'script') { blocked++; await gate; }
                await route.continue();
            });
            const position = () => page.locator('#catalogue-results').evaluate(node => ({ top: node.getBoundingClientRect().top, open: document.querySelector('.listing-filters').open }));
            try {
                await page.goto(`${origin}/search`, { waitUntil: 'commit' });
                await page.locator('#catalogue-results').waitFor({ state: 'attached' });
                await page.waitForFunction(() => getComputedStyle(document.querySelector('.listing-shell')).display === (innerWidth <= 720 ? 'block' : 'grid'));
                await page.waitForTimeout(700); // Let the pre-JS state paint; deliberate slow-script regression.
                assert.ok(blocked > 0, 'script loading was actually delayed');
                const before = await position();
                releaseScripts();
                await page.waitForLoadState('load');
                await page.waitForTimeout(150);
                const after = await position();
                const movement = Math.abs(before.top - after.top);
                rows.push({ engine, width, before, after, movement, blocked });
                if (baseline && width <= 720) {
                    assert.equal(before.open, true);
                    assert.equal(after.open, false);
                    assert.ok(movement > 100, 'original mobile filter collapse reproduced');
                } else {
                    if (!baseline) assert.equal(before.open, false, 'SSR closed disclosure');
                    assert.equal(after.open, width > 720, 'desktop-only initial expansion');
                    assert.ok(movement <= 1, 'results did not jump on script completion');
                }
                if (!baseline) {
                    const image = page.locator('.experience-card img').first();
                    assert.equal(await image.getAttribute('loading'), 'eager');
                    assert.equal(await image.getAttribute('fetchpriority'), 'high');
                    assert.equal(await page.locator('.experience-card img[loading="eager"]').count(), 1);
                    if (width <= 720) {
                        await page.locator('.listing-filters summary').focus();
                        await page.keyboard.press('Enter');
                        assert.ok(await page.locator('#catalogue-filter-form').isVisible());
                    }
                    if (width === 390 || width === 1440) await page.screenshot({ path: `${output}/stable-${engine}-${width}.png`, fullPage: true });
                }
            } catch (error) { failures.push({ engine, width, error: error.message }); }
            finally { releaseScripts(); await context.close(); }
        }
        if (!baseline) {
            const context = await browser.newContext({ javaScriptEnabled: false, viewport: { width: 390, height: 1000 } });
            const page = await context.newPage();
            try {
                await page.goto(`${origin}/search`);
                await page.locator('.listing-filters summary').click();
                assert.ok(await page.locator('#catalogue-filter-form').isVisible());
                await page.locator('#catalogue-query').fill('boat');
                await page.locator('#catalogue-filter-form button[type="submit"]').click();
                assert.ok(new URL(page.url()).searchParams.get('q') === 'boat');
                await page.goto(`${origin}/cruises/dubai/sample-creek-cruise`);
                assert.equal(await page.locator('.detail-art img').getAttribute('loading'), 'eager');
                assert.equal(await page.locator('.detail-art img').getAttribute('fetchpriority'), 'high');
                assert.equal(await page.locator('.gallery-tile img[loading="lazy"]').count(), 6);
                rows.push({ engine, mode: 'no-js', filters: 'native submit passed', detailPriority: 'passed' });
            } catch (error) { failures.push({ engine, mode: 'no-js', error: error.message }); }
            finally { await context.close(); }
        }
    } finally { await browser.close(); }
}
await fs.writeFile(`${output}/${baseline ? 'old-shift-reproduction' : 'loading-stability'}.json`, JSON.stringify({ origin, baseline, rows, failures }, null, 2));
console.log(JSON.stringify({ origin, baseline, rows, failures }));
if (failures.length) process.exitCode = 1;
