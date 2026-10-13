import { chromium } from '/tmp/bookorgo-browser/node_modules/playwright/index.mjs';
import fs from 'node:fs/promises';
import assert from 'node:assert/strict';

const browser = await chromium.launch();
const output = new URL('../../test-results/', import.meta.url);
await fs.mkdir(output, { recursive: true });
const failures = [];
const checks = [];

async function verifyPhotos(page) {
    const results = await page.locator('img.destination-photo').evaluateAll(async images => Promise.all(images.map(async image => {
        image.loading = 'eager';
        try { await image.decode(); } catch {}
        return { loaded: image.complete && image.naturalWidth > 0, sameOrigin: new URL(image.currentSrc).origin === location.origin };
    })));
    assert.ok(results.length > 0);
    assert.ok(results.every(image => image.loaded && image.sameOrigin), 'all destination photos load from the same origin');
}

try {
    for (const width of [1920, 1440, 768, 390, 320]) {
        const context = await browser.newContext({ viewport: { width, height: 1000 } });
        const page = await context.newPage();
        page.on('pageerror', error => failures.push(error.message));

        const response = await page.goto('http://127.0.0.1:8000/');
        assert.equal(response.status(), 200);
        assert.equal(response.headers()['x-robots-tag'], 'noindex, nofollow');
        await page.locator('h1').waitFor();
        assert.equal(await page.locator('h1').count(), 1);
        assert.equal(await page.locator('.site-header').evaluate(el => getComputedStyle(el).backgroundColor), 'rgb(6, 43, 111)');
        assert.equal(await page.locator('.hero .search-form').evaluate(el => getComputedStyle(el).borderTopColor), 'rgb(255, 196, 0)');
        assert.equal(await page.locator('.destination-card').count(), 6);
        assert.equal(await page.locator('.featured-card').count(), 4);
        assert.equal(await page.locator('.region-card').count(), 8);
        await verifyPhotos(page);
        assert.ok(await page.evaluate(async () => { await document.fonts.load('700 32px Inter'); return document.fonts.check('700 32px Inter'); }));
        assert.ok(await page.locator('#newsletter-preview').isDisabled());
        assert.ok(await page.locator('#preview-date').isDisabled());
        assert.ok(await page.locator('#preview-travellers').isDisabled());
        if (width === 1920) {
            const hero = await page.locator('.hero').boundingBox();
            const search = await page.locator('.hero .search-form').boundingBox();
            assert.ok(search.y < hero.y + hero.height && search.y + search.height > hero.y + hero.height, 'search overlaps hero edge');
            assert.equal(Math.round(search.width), 1152);
        }
        await page.screenshot({ path: new URL(`homepage-${width}.png`, output).pathname, fullPage: true });
        const overflow = await page.evaluate(() => [...document.querySelectorAll('body *')].filter(el => el.getBoundingClientRect().right > innerWidth + 1).map(el => ({ tag: el.tagName, class: el.getAttribute('class'), right: el.getBoundingClientRect().right })).slice(0, 12));
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth), JSON.stringify({ width, overflow }));

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
        assert.equal(await page.locator('.inspiration-card').count(), 3);
        await verifyPhotos(page);
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

        if (width === 1920 || width === 1440 || width === 390) {
            await page.screenshot({ path: new URL(`listing-${width}.png`, output).pathname, fullPage: true });
        }

        await page.getByRole('link', { name: /View sample detail/ }).first().click();
        assert.ok(await page.getByText('Layout demonstration only.').isVisible());
        assert.ok(await page.getByRole('button', { name: /Check verified/ }).isDisabled());
        assert.equal(await page.locator('h1').count(), 1);
        assert.equal(await page.locator('.field-grid > div').count(), 6);
        assert.equal(await page.locator('.gallery-tile').count(), 6);
        await verifyPhotos(page);
        assert.equal(await page.locator('.review-empty-grid > div').count(), 2);
        assert.equal(await page.locator('.detail-faq details').count(), 4);
        await page.locator('.detail-faq summary').first().focus();
        await page.keyboard.press('Enter');
        assert.ok(await page.getByText('The referral control stays disabled', { exact: false }).isVisible());
        assert.ok(await page.locator('.detail-heading').evaluate(el => el.getBoundingClientRect().bottom) <= await page.locator('.detail-art').evaluate(el => el.getBoundingClientRect().top));
        assert.ok(await page.locator('.related-grid article').count() === 2);
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
        if (width === 1920 || width === 1440 || width === 390) {
            await page.evaluate(() => { document.activeElement?.blur(); window.scrollTo(0, 0); });
            await page.screenshot({ path: new URL(`detail-${width}.png`, output).pathname, fullPage: true });
        }

        await page.goto('http://127.0.0.1:8000/blog');
        assert.equal(await page.locator('.article-card').count(), 3);
        assert.ok(await page.getByText('Drafts only.').isVisible());
        await page.getByRole('link', { name: 'Open article template' }).first().click();
        assert.ok(await page.getByText('No factual sources attached').isVisible());
        assert.ok(await page.getByText('Inactive preview — no ad loaded').isVisible());
        assert.equal(await page.locator('.article-section').count(), 3);
        assert.equal(await page.locator('h1').count(), 1);
        assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
        if (width === 1440 || width === 390) {
            await page.screenshot({ path: new URL(`article-${width}.png`, output).pathname, fullPage: true });
        }

        checks.push({ viewport: width, homepage: 'pass', listing: 'pass', detail: 'pass', article: 'pass', filters: 'pass', overflow: 'pass' });
        await context.close();
    }

    const interaction = await browser.newContext({ viewport: { width: 390, height: 900 } });
    const interactivePage = await interaction.newPage();
    interactivePage.on('pageerror', error => failures.push(error.message));
    await interactivePage.goto('http://127.0.0.1:8000/search');
    await interactivePage.locator('.listing-filters summary').click();
    await interactivePage.locator('input[name="category"][value="yachts"]').check();
    await interactivePage.locator('input[name="area"][value="Dubai Marina"]').check();
    await interactivePage.locator('input[name="duration"][value="under-2-hours"]').check();
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
    await interactivePage.getByRole('link', { name: 'Title Z–A', exact: true }).click();
    assert.equal(new URL(interactivePage.url()).searchParams.get('sort'), 'title-desc');
    assert.equal(new URL(interactivePage.url()).searchParams.get('q'), 'sample');
    checks.push({ externalFormSort: 'pass', filtersPreserved: 'pass' });
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
    await noJsPage.goto('http://127.0.0.1:8000/activities/dubai/sample-desert-morning');
    await noJsPage.locator('.detail-faq summary').first().click();
    assert.ok(await noJsPage.getByText('The referral control stays disabled', { exact: false }).isVisible());
    await noJsPage.goto('http://127.0.0.1:8000/blog/sample-first-visit-planning');
    assert.ok(await noJsPage.getByRole('navigation', { name: 'On this page' }).isVisible());
    await noJsPage.getByRole('link', { name: 'Start with the purpose of the trip' }).click();
    assert.equal(new URL(noJsPage.url()).hash, '#start-with-purpose');
    await noJsPage.screenshot({ path: new URL('listing-empty-390.png', output).pathname, fullPage: true });
    checks.push({ javascriptDisabled: 'pass', internalLinks: paths.length, emptySearch: 'pass' });
    await noJs.close();

    assert.deepEqual(failures, []);
    await fs.writeFile(new URL('browser-evidence.json', output), JSON.stringify({ checks, pageErrors: failures }, null, 2));
} finally {
    await browser.close();
}
