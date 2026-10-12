# P1-01 — Homepage and discovery foundation

Date: 12 October 2026. Status: **CI-verified foundation slice; no Hostinger deployment**.

Fresh application source is in `site/`, based on a clean official Laravel skeleton. Implemented navy/blue/yellow UAE homepage, six discoverable navigation categories, responsive native mobile menu, GET category search, truthful empty category pages and an unpublished travel-journal page. All content is labelled preview and noindex. Original CSS illustrations/system fonts avoid importing prototype assets or unverified media.

Tested revision: `f8a1c71403dcf1c5473542ffa395af1b6cc60d8f`.
[Successful build and browser checks](https://github.com/bookorgo/BookOrGo/actions/runs/38249192582).

- PHP 8.3.35: locked Composer install, 5 feature tests / 65 assertions; safe scalar/length search validation, XSS escaping, category 404s, configured canonical origin, noindex and database-independent homepage.
- Tailwind/Vite production build: PASS. Route, Blade and configuration caches: PASS.
- Chromium 1440/768/390/320: home/search, no horizontal overflow, mobile keyboard/native menu behavior: PASS. JavaScript disabled: menu/search/empty state and eight distinct internal link targets: PASS. No browser page errors.
- Visually inspected homepage at 1440/768/390 plus mobile search. Final artifact screenshots match the inspected images byte-for-byte. Owner visual acceptance, full WCAG assessment, Safari/Firefox and performance budgets remain unverified.

Requirement mapping: Playbook P1-01/UI-01 and supporting P1-05 checks; Master §03 homepage/navigation/mobile and §08 server-rendered metadata/indexation. Full homepage content requirements are not all delivered: product/area discovery, substantive guides, policies and related editorial work remain. This is a bounded foundation slice, not full P1 completion.

Corrected failures are retained in evidence/P1-01-foundation.json: the original PHP 8.4 dependency lock failed on PHP 8.3; a test assumed the wrong CI host; the JS-disabled browser test needed to close the menu before searching. Final tests did not skip these paths or force blocked clicks.

Artifact 11747646484 contains eight screenshots, browser-evidence.json and the Composer lock; expires 2026-10-26T12:29:01Z. Digest: `sha256:03bd1c4f8be617f566e48b4728de7ccc5f6cb36e5e2395ef644861265c684101`.

Deployment: none. Existing Hostinger/Sites/files/audience/URLs preserved. Next is the actual main release under P1_MAIN_RELEASE_PLAN.md using existing SSH, followed by P1-02 listing work. No database or scheduler is required by this slice. No new access is requested for that next package. Full catalogue search, products/detail/article templates, database/CMS, verified content and production checks remain.
