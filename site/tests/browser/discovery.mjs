import { chromium } from '/tmp/bookorgo-browser/node_modules/playwright/index.mjs';
import fs from 'node:fs/promises';
import assert from 'node:assert/strict';

const browser = await chromium.launch();
const output = new URL('../../test-results/', import.meta.url);
await fs.mkdir(output, { recursive: true });
const failures = [];
const checks = [];
try {
    for (const width of [1440, 768, 390, 320]) {
        const context = await browser.newContext({ viewport: { width, height: 1000 } });
        const page = await context.newPage();
        page.on('pageerror', error => failures.push(error.message));
        const response = await page.goto('http://127.0.0.1:8000/');
        assert.equal(response.status(), 200);
        assert.equal(response.headers()['x-robots-tag'], 'noindex, nofollow');
        await page.locator('h1').waitFor();
        assert.equal(await page.locator('h1').count(), 1);
        assert.ok(await page.locator('h1').isVisible());
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
        await page.screenshot({ path: new URL(`homepage-${width}.png`, output).pathname, fullPage: true });
        if (width < 720) {
            const toggle = page.locator('.mobile-menu summary');
            await toggle.focus();
            await page.keyboard.press('Enter');
            assert.ok(await page.locator('.mobile-menu nav').isVisible());
            await page.keyboard.press('Escape');
            assert.equal(await page.locator('.mobile-menu').getAttribute('open'), null);
            await toggle.click();
            await page.locator('.mobile-menu nav a').filter({ hasText: 'Yachts' }).click();
            assert.match(await page.locator('h1').innerText(), /Yachts/);
            await page.goto('http://127.0.0.1:8000/');
        }
        await page.getByLabel('What would you like to explore?').fill('boat');
        await page.getByRole('button', { name: 'Explore' }).click();
        assert.equal(await page.locator('.category-card').count(), 2);
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
        await page.screenshot({ path: new URL(`search-${width}.png`, output).pathname, fullPage: true });
        checks.push({ viewport: width, homepage: 'pass', search: 'pass', overflow: 'pass', menu: width < 720 ? 'pass' : 'not applicable' });
        await context.close();
    }
    const context = await browser.newContext({ javaScriptEnabled: false, viewport: { width: 390, height: 900 } });
    const page = await context.newPage();
    await page.goto('http://127.0.0.1:8000/');
    const paths = await page.locator('a[href]').evaluateAll(links => [...new Set(links.map(link => link.getAttribute('href')).filter(href => !href.startsWith('#')))]);
    for (const url of paths) {
        const response = await context.request.get(url);
        assert.equal(response.status(), 200, url);
    }
    await page.locator('.mobile-menu summary').click();
    assert.ok(await page.locator('.mobile-menu nav').isVisible());
    await page.getByLabel('What would you like to explore?').fill('xyz-no-match');
    await page.getByRole('button', { name: 'Explore' }).click();
    assert.ok(await page.getByRole('heading', { name: 'No matching categories yet' }).isVisible());
    checks.push({ javascriptDisabled: 'pass', internalLinks: paths.length, emptySearch: 'pass' });
    assert.deepEqual(failures, []);
    await fs.writeFile(new URL('browser-evidence.json', output), JSON.stringify({ checks, pageErrors: failures }, null, 2));
} finally {
    await browser.close();
}
