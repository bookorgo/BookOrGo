import { chromium, firefox, webkit } from '/tmp/bookorgo-quality/node_modules/playwright/index.mjs';
import fs from 'node:fs/promises';
import assert from 'node:assert/strict';
import { createHash } from 'node:crypto';

const origin = process.env.BOOKORGO_AUDIT_ORIGIN || 'https://bookorgo.com';
assert.ok(['https://bookorgo.com', 'http://127.0.0.1:8000'].includes(origin), 'approved audit origin only');
const output = 'site/test-results/quality';
await fs.mkdir(output, { recursive: true });
const routes = [['home', '/'], ['listing', '/search'], ['detail', '/cruises/dubai/sample-creek-cruise'], ['article', '/blog/sample-first-visit-planning']];
const rows = [], failures = [];
const luminance = rgb => rgb.slice(0, 3).map(value => value / 255).map(value => value <= .04045 ? value / 12.92 : ((value + .055) / 1.055) ** 2.4).reduce((sum, value, index) => sum + value * [.2126, .7152, .0722][index], 0);
const contrast = (a, b) => (Math.max(luminance(a), luminance(b)) + .05) / (Math.min(luminance(a), luminance(b)) + .05);
async function checkCaptionContrast(page) {
    // Conservative bound: composite the backing on pure white, brighter than
    // any photo. This checks these captions only, not every page pixel.
    const samples = await page.locator('.destination-copy, .category-card .card-copy, .region-card>span, .inspiration-card>span, .detail-gallery .detail-art>p, .gallery-tile>span').evaluateAll(elements => elements.flatMap(element => {
        if (!element.getClientRects().length) return [];
        const rgba = value => value.match(/[\d.]+/g).map(Number);
        const background = rgba(getComputedStyle(element).backgroundColor);
        return [element, ...element.querySelectorAll('*')].filter(node => [...node.childNodes].some(child => child.nodeType === Node.TEXT_NODE && child.textContent.trim()) && !node.closest('[aria-hidden="true"]')).map(node => ({
            text: node.textContent.trim(), background, foreground: rgba(getComputedStyle(node).color),
            opacity: getComputedStyle(node).opacity, containerOpacity: getComputedStyle(element).opacity,
        }));
    }));
    for (const sample of samples) {
        const alpha = sample.background[3] ?? 1;
        assert.ok(alpha >= .9, 'caption needs an effective backing');
        assert.equal(sample.opacity, '1');
        assert.equal(sample.containerOpacity, '1');
        assert.equal(sample.foreground[3] ?? 1, 1);
        const brightest = sample.background.slice(0, 3).map(value => value * alpha + 255 * (1 - alpha));
        sample.minimumRatio = Number(contrast(sample.foreground, brightest).toFixed(3));
        assert.ok(sample.minimumRatio >= 4.5, `caption contrast: ${sample.text}`);
    }
    return samples;
}
for (const [engine, type] of Object.entries({ chromium, firefox, webkit })) {
    const browser = await type.launch();
    try {
        for (const width of [1440, 390]) {
            const context = await browser.newContext({ viewport: { width, height: 1000 } });
            const page = await context.newPage();
            const errors = [];
            page.on('pageerror', error => errors.push(error.message));
            for (const [name, path] of routes) {
                const row = { engine, width, page: name, path, checkedAt: new Date().toISOString() };
                rows.push(row);
                try {
                    const response = await page.goto(origin + path, { waitUntil: 'networkidle' });
                    assert.equal(response.status(), 200);
                    assert.equal(response.headers()['x-robots-tag'], 'noindex, nofollow');
                    assert.equal(await page.locator('h1').count(), 1);
                    assert.equal(await page.locator('link[rel="canonical"]').getAttribute('href'), origin + path.split('?')[0]);
                    const body = await response.body();
                    row.htmlSha256 = createHash('sha256').update(body).digest('hex');
                    await page.locator('img.destination-photo').evaluateAll(async images => Promise.all(images.map(async image => { image.loading = 'eager'; await image.decode(); })));
                    await page.evaluate(async () => { await document.fonts.ready; });
                    assert.ok(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth));
                    await page.keyboard.press('Tab');
                    assert.equal(await page.evaluate(() => document.activeElement?.getAttribute('href')), '#main');
                    await page.keyboard.press('Enter');
                    assert.equal(await page.evaluate(() => document.activeElement?.id), 'main');
                    if (name === 'home' && width === 390) {
                        await page.locator('.mobile-menu summary').focus();
                        await page.keyboard.press('Enter');
                        assert.ok(await page.locator('.mobile-menu nav').isVisible());
                        await page.keyboard.press('Escape');
                        assert.equal(await page.locator('.mobile-menu').getAttribute('open'), null);
                        assert.equal(await page.evaluate(() => document.activeElement?.tagName), 'SUMMARY');
                    }
                    if (name === 'detail') {
                        const dates = page.getByRole('group', { name: 'Inactive date preview', exact: true });
                        assert.equal(await dates.getByRole('button', { name: 'Date unavailable' }).count(), 4);
                        for (const button of await dates.getByRole('button').all()) assert.ok(await button.isDisabled());
                        assert.ok(await page.getByRole('button', { name: /Check verified/ }).isDisabled());
                        await page.locator('.detail-faq summary').first().focus();
                        await page.keyboard.press('Enter');
                        assert.ok(await page.getByText('The referral control stays disabled', { exact: false }).isVisible());
                    }
                    if (name === 'listing') {
                        await page.locator('.listing-filters').evaluate(el => el.setAttribute('open', ''));
                        assert.equal(await page.locator('.inspiration-card').count(), 3);
                    }
                    if (name === 'article') assert.ok(await page.getByRole('group', { name: 'Inactive advertising preview', exact: true }).isVisible());
                    row.captionContrast = await checkCaptionContrast(page);
                    await page.addScriptTag({ path: '/tmp/bookorgo-quality/node_modules/axe-core/axe.min.js' });
                    const audit = await page.evaluate(async () => axe.run(document, { runOnly: { type: 'tag', values: ['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'wcag22aa', 'best-practice'] } }));
                    const filename = `${engine}-${width}-${name}`;
                    await fs.writeFile(`${output}/${filename}-axe.json`, JSON.stringify(audit, null, 2));
                    row.violations = audit.violations.map(rule => ({ id: rule.id, impact: rule.impact, help: rule.help, helpUrl: rule.helpUrl, nodes: rule.nodes.map(node => ({ target: node.target, failureSummary: node.failureSummary })) }));
                    row.manualReviewRules = audit.incomplete.map(rule => rule.id);
                    assert.ok(!row.manualReviewRules.includes('aria-prohibited-attr'), 'remaining ARIA naming issue requires review');
                    row.functional = 'PASS';
                    row.accessibility = row.violations.length ? 'FINDINGS_REQUIRE_FIX' : 'NO_AUTOMATED_VIOLATIONS';
                    await page.evaluate(() => { document.activeElement?.blur(); scrollTo(0, 0); });
                    await page.screenshot({ path: `${output}/${filename}.png`, fullPage: true });
                } catch (error) {
                    row.functional = 'FAIL'; row.error = error.message;
                    failures.push({ engine, width, page: name, error: error.message });
                }
            }
            try {
                await page.goto(origin + '/search');
                await page.locator('.listing-filters').evaluate(el => el.setAttribute('open', ''));
                await page.locator('input[name="category"][value="yachts"]').check();
                await page.locator('input[name="area"][value="Dubai Marina"]').check();
                await page.getByRole('button', { name: /Apply filters/ }).click();
                assert.equal(await page.locator('.experience-card').count(), 1);
                await page.getByRole('link', { name: 'Title Z–A', exact: true }).click();
                assert.equal(new URL(page.url()).searchParams.get('category'), 'yachts');
                assert.equal(new URL(page.url()).searchParams.get('area'), 'Dubai Marina');
                assert.equal(new URL(page.url()).searchParams.get('sort'), 'title-desc');
            } catch (error) { failures.push({ engine, width, page: 'filter-sort', error: error.message }); }
            for (const error of errors) failures.push({ engine, width, page: 'runtime', error });
            await context.close();
        }
    } finally { await browser.close(); }
}
const uniqueRules = [...new Set(rows.flatMap(row => (row.violations || []).map(rule => rule.id)))];
const report = { task: 'P1-05a', sourceRevision: process.env.GITHUB_SHA, targetOrigin: origin, mode: origin.startsWith('http://127.0.0.1') ? 'CI_SOURCE' : 'LIVE_READ_ONLY', readOnly: true, checkedAt: new Date().toISOString(), rows, failures, uniqueRules, limitations: 'Automated audit, not WCAG certification. Browser engines are not physical Safari/iOS/Android devices. No performance/CWV or screen-reader acceptance claim. Accessibility findings do not make this an accessibility pass.' };
await fs.writeFile(output + '/summary.json', JSON.stringify(report, null, 2));
console.log(JSON.stringify({ pages: rows.length, functionalFailures: failures.length, pagesWithAccessibilityFindings: rows.filter(row => row.violations?.length).length, uniqueRules }));
assert.deepEqual(failures, [], 'functional/browser failures: see saved summary');

if (process.env.BOOKORGO_REQUIRE_CLEAN_A11Y === 'true') assert.deepEqual(uniqueRules, [], 'automated accessibility findings: see saved report');
