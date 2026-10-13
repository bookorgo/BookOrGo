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
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
        await page.screenshot({ path: new URL(`homepage-${width}.png`, output).pathname, fullPage: true });

        if (width < 720) {
            const toggle = page.locator('.mobile-menu summary');
            await toggle.focus();
            await page.keyboard.press('Enter');
            assert.ok(await page.locator('.mobile-menu nav').isVisible());
            await page.keyboard.press('Escape');
            assert.equal(await page.locator('.mobile-menu').getAttribute('open'), null);
        }

        await page.getByLabel('What would you like to explore?').fill('boat');
        await page.getByRole('button', { name: 'Explore' }).click();
        assert.equal(await page.locator('.experience-card').count(), 6);
        assert.ok(await page.getByText('6 fictional cards').isVisible());
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));

        const listingFilters = page.locator('.listing-filters');
        if (width <= 720) {
            assert.equal(await listingFilters.getAttribute('open'), null);
            await listingFilters.locator('summary').click();
            assert.ok(await listingFilters.locator('form').isVisible());
        } else {
            assert.notEqual(await listingFilters.getAttribute('open'), null);
            assert.ok(await listingFilters.locator('form').isVisible());
        }

        if (width === 1440 || width === 390) {
            await page.screenshot({ path: new URL(`listing-${width}.png`, output).pathname, fullPage: true });
        }

        checks.push({ viewport: width, homepage: 'pass', listing: 'pass', filters: 'pass', overflow: 'pass' });
        await context.close();
    }

    const interaction = await browser.newContext({ viewport: { width: 390, height: 900 } });
    const interactivePage = await interaction.newPage();
    interactivePage.on('pageerror', error => failures.push(error.message));
    await interactivePage.goto('http://127.0.0.1:8000/search');
    await interactivePage.locator('.listing-filters summary').click();
    await interactivePage.getByLabel('Category').selectOption('yachts');
    await interactivePage.getByLabel('Area').selectOption('Dubai Marina');
    await interactivePage.getByLabel('Duration').selectOption('under-2-hours');
    await interactivePage.getByLabel('Sample yes').check();
    await interactivePage.getByRole('button', { name: /Apply filters/ }).click();
    await interactivePage.locator('.experience-card').waitFor();
    assert.equal(await interactivePage.locator('.experience-card').count(), 1);
    assert.ok(await interactivePage.getByText('Marina yacht layout concept').isVisible());

    await interactivePage.goto('http://127.0.0.1:8000/search');
    await interactivePage.evaluate(() => {
        const form = document.querySelector('[data-listing-form]');
        form.addEventListener('submit', event => event.preventDefault(), { once: true });
        form.requestSubmit();
    });
    assert.equal(await interactivePage.locator('#catalogue-results').getAttribute('aria-busy'), 'true');
    assert.ok(await interactivePage.locator('[data-loading-status]').isVisible());

    await interactivePage.goto('http://127.0.0.1:8000/search?q=sample');
    await interactivePage.getByRole('link', { name: 'Page 2' }).click();
    assert.ok(await interactivePage.getByText('Page 2 of 3').isVisible());
    assert.equal(await interactivePage.locator('.experience-card').count(), 6);
    checks.push({ filteredNavigation: 'pass', loadingState: 'pass', pagination: 'pass' });
    await interaction.close();

    const noJs = await browser.newContext({ javaScriptEnabled: false, viewport: { width: 390, height: 900 } });
    const noJsPage = await noJs.newPage();
    await noJsPage.goto('http://127.0.0.1:8000/');
    const paths = await noJsPage.locator('a[href]').evaluateAll(links => [...new Set(links.map(link => link.getAttribute('href')).filter(href => !href.startsWith('#')))]);
    for (const url of paths) {
        const response = await noJs.request.get(url);
        assert.equal(response.status(), 200, url);
    }
    await noJsPage.locator('.mobile-menu summary').click();
    assert.ok(await noJsPage.locator('.mobile-menu nav').isVisible());
    await noJsPage.locator('.mobile-menu summary').click();
    assert.equal(await noJsPage.locator('.mobile-menu').getAttribute('open'), null);
    await noJsPage.getByLabel('What would you like to explore?').fill('xyz-no-match');
    await noJsPage.getByRole('button', { name: 'Explore' }).click();
    assert.ok(await noJsPage.getByRole('heading', { name: 'No sample cards match' }).isVisible());
    await noJsPage.screenshot({ path: new URL('listing-empty-390.png', output).pathname, fullPage: true });
    checks.push({ javascriptDisabled: 'pass', internalLinks: paths.length, emptySearch: 'pass' });
    await noJs.close();

    assert.deepEqual(failures, []);
    await fs.writeFile(new URL('browser-evidence.json', output), JSON.stringify({ checks, pageErrors: failures }, null, 2));
} finally {
    await browser.close();
}
