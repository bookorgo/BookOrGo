import { chromium } from '/tmp/bookorgo-live-browser/node_modules/playwright/index.mjs';
import assert from 'node:assert/strict';
import fs from 'node:fs/promises';

const origin = 'https://bookorgo.com';
const output = new URL('../../site/test-results/', import.meta.url);
await fs.mkdir(output, { recursive: true });
const browser = await chromium.launch();
const checks = [];
const errors = [];

try {
    for (const width of [1440, 390]) {
        const context = await browser.newContext({ viewport: { width, height: 1000 } });
        const page = await context.newPage();
        page.on('pageerror', error => errors.push(error.message));
        const response = await page.goto(origin + '/', { waitUntil: 'networkidle' });
        assert.equal(response.status(), 200);
        assert.equal(response.headers()['x-robots-tag'], 'noindex, nofollow');
        assert.equal(await page.locator('h1').count(), 1);
        assert.ok(await page.getByText('Development preview', { exact: true }).isVisible());
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
        if (width === 390) {
            const menu = page.locator('.mobile-menu summary');
            await menu.focus();
            await page.keyboard.press('Enter');
            assert.ok(await page.locator('.mobile-menu nav').isVisible());
            await page.keyboard.press('Escape');
            assert.equal(await page.locator('.mobile-menu').getAttribute('open'), null);
        }
        await page.getByLabel('What would you like to explore?').fill('boat');
        await Promise.all([
            page.waitForURL(origin + '/search?q=boat'),
            page.getByRole('button', { name: 'Explore' }).click(),
        ]);
        assert.equal(await page.locator('.category-card').count(), 2);
        assert.ok(await page.getByRole('heading', { name: 'Cruises' }).isVisible());
        assert.ok(await page.getByRole('heading', { name: 'Yachts' }).isVisible());
        await page.screenshot({ path: new URL(`live-search-${width}.png`, output).pathname, fullPage: true });
        await page.goto(origin + '/');
        await page.screenshot({ path: new URL(`live-homepage-${width}.png`, output).pathname, fullPage: true });
        checks.push({ viewport: width, homepage: 'pass', search: 'pass', overflow: 'pass', menu: width === 390 ? 'pass' : 'not applicable' });
        await context.close();
    }
    assert.deepEqual(errors, []);
    await fs.writeFile(new URL('live-browser.json', output), JSON.stringify({ checks, pageErrors: errors }, null, 2));
} finally {
    await browser.close();
}
