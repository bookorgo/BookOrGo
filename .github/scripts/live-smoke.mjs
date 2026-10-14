import { chromium } from '/tmp/bookorgo-live-browser/node_modules/playwright/index.mjs';
import assert from 'node:assert/strict';
import fs from 'node:fs/promises';

const origin = 'https://bookorgo.com';
const output = new URL('../../site/test-results/', import.meta.url);
await fs.mkdir(output, { recursive: true });
const browser = await chromium.launch();
const checks = [];
const errors = [];

async function verifyPhotos(page) {
 const results = await page.locator('img.destination-photo').evaluateAll(async images => Promise.all(images.map(async image => {
 image.loading = 'eager'; try { await image.decode(); } catch {}
 return image.complete && image.naturalWidth > 0 && new URL(image.currentSrc).origin === location.origin;
 })));
 assert.ok(results.length > 0 && results.every(Boolean), 'all destination photos load from the same origin');
}
try {
    for (const width of [1440, 390]) {
        const context = await browser.newContext({ viewport: { width, height: 1000 } });
        const page = await context.newPage();
        page.on('pageerror', error => errors.push(error.message));
        const response = await page.goto(origin + '/', { waitUntil: 'networkidle' });
        assert.equal(response.status(), 200);
        assert.equal(response.headers()['x-robots-tag'], 'noindex, nofollow');
        assert.equal(await page.locator('h1').count(), 1);
        assert.equal(await page.locator('.destination-card').count(), 6);
        assert.equal(await page.locator('.featured-card').count(), 4);
        assert.equal(await page.locator('.region-card').count(), 8);
        await verifyPhotos(page);
        assert.ok(await page.evaluate(async () => { await document.fonts.load('700 32px Inter'); return document.fonts.check('700 32px Inter'); }));
        assert.ok(await page.locator('#newsletter-preview').isDisabled());
        assert.equal(await page.locator('.site-header').evaluate(el => getComputedStyle(el).backgroundColor), 'rgb(6, 43, 111)');
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
        assert.equal(await page.locator('.experience-card').count(), 6);
        assert.equal(await page.locator('.inspiration-card').count(), 3);
        await verifyPhotos(page);
        assert.ok(await page.getByText('6 fictional cards').isVisible());
        assert.ok(await page.getByText('Demonstration data only.').isVisible());
        const filters = page.locator('.listing-filters');
        if (width === 390) {
            assert.equal(await filters.getAttribute('open'), null);
            await filters.locator('summary').click();
        } else {
            assert.notEqual(await filters.getAttribute('open'), null);
        }
        assert.ok(await filters.locator('form').isVisible());
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
        await page.screenshot({ path: new URL(`live-listing-${width}.png`, output).pathname, fullPage: true });

        await Promise.all([
            page.waitForURL(url => url.pathname.startsWith('/cruises/')),
            page.getByRole('link', { name: /View sample detail/ }).first().click(),
        ]);
        assert.ok(await page.getByText('Layout demonstration only.').isVisible());
        assert.ok(await page.getByRole('button', { name: /Check verified cruise options/ }).isDisabled());
        assert.equal(await page.locator('.field-grid > div').count(), 6);
        assert.equal(await page.locator('.gallery-tile').count(), 6);
        await verifyPhotos(page);
        assert.equal(await page.locator('.review-empty-grid > div').count(), 2);
        await page.locator('.detail-faq summary').first().focus();
        await page.keyboard.press('Enter');
        assert.ok(await page.getByText('The referral control stays disabled', { exact: false }).isVisible());
        assert.equal(await page.locator('.related-grid article').count(), 2);
        assert.equal(await page.locator('h1').count(), 1);
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
        await page.evaluate(() => { document.activeElement?.blur(); window.scrollTo(0, 0); });
        await page.screenshot({ path: new URL(`live-detail-${width}.png`, output).pathname, fullPage: true });

        await page.goto(origin + '/blog');
        assert.equal(await page.locator('.article-card').count(), 3);
        await page.getByRole('link', { name: 'Open article template' }).first().click();
        assert.ok(await page.getByText('No factual sources attached').isVisible());
        assert.ok(await page.getByText('Inactive preview — no ad loaded').isVisible());
        assert.equal(await page.locator('.article-section').count(), 3);
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
        await page.screenshot({ path: new URL(`live-article-${width}.png`, output).pathname, fullPage: true });

        await page.goto(origin + '/');
        await verifyPhotos(page);
        await page.evaluate(async () => { await document.fonts.ready; });
        await page.screenshot({ path: new URL(`live-homepage-${width}.png`, output).pathname, fullPage: true });
        checks.push({ viewport: width, homepage: 'pass', listing: 'pass', detail: 'pass', gallery: 'pass', faq: 'pass', article: 'pass', filters: 'pass', overflow: 'pass', menu: width === 390 ? 'pass' : 'not applicable' });
        await context.close();
    }

    const interaction = await browser.newContext({ viewport: { width: 390, height: 1000 } });
    const page = await interaction.newPage();
    page.on('pageerror', error => errors.push(error.message));
    await page.goto(origin + '/search');
    await page.locator('.listing-filters summary').click();
    await page.locator('input[name="category"][value="yachts"]').check();
    await page.locator('input[name="area"][value="Dubai Marina"]').check();
    await page.locator('input[name="duration"][value="under-2-hours"]').check();
    await page.getByLabel('Sample yes').check();
    await Promise.all([
        page.waitForURL(url => url.pathname === '/search' && url.searchParams.get('category') === 'yachts'),
        page.getByRole('button', { name: /Apply filters/ }).click(),
    ]);
    assert.equal(await page.locator('.experience-card').count(), 1);
    assert.ok(await page.getByText('Marina yacht layout concept').isVisible());
    await page.goto(origin + '/search?q=sample');
    await page.getByRole('link', { name: 'Page 2' }).click();
    assert.ok(await page.getByText('Page 2 of 3').isVisible());
    assert.equal(await page.locator('.experience-card').count(), 6);
    checks.push({ filteredNavigation: 'pass', pagination: 'pass' });
    await page.getByRole('link', { name: 'Title Z–A', exact: true }).click();
    assert.equal(new URL(page.url()).searchParams.get('sort'), 'title-desc');
    assert.equal(new URL(page.url()).searchParams.get('q'), 'sample');
    checks.push({ sorting: 'pass', queryPreserved: 'pass' });
    await interaction.close();
    assert.deepEqual(errors, []);
    await fs.writeFile(new URL('live-browser.json', output), JSON.stringify({ checks, pageErrors: errors }, null, 2));
} finally {
    await browser.close();
}
