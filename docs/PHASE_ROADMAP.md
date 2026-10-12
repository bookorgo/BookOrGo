# BookOrGo phase roadmap

Latest override: OWNER_MAIN_ONLY.md (12 October 2026) permits independent P1 implementation on main while operational P0 checks remain open. No separate staging or temporary Hostinger database prerequisite; no destructive testing on the application database.
Date: 12 October 2026 (Asia/Karachi)
Authority: Master Requirements V3.1 and AI Execution Playbook V4.1; latest owner direction overrides temporary Sites exception.
Target: Laravel 13, Blade SSR, selective Livewire 4/Alpine, Tailwind, MySQL/MariaDB, minimal compatible Filament. GitHub + Hostinger Premium. Fresh build; previous prototype must not be reused. Latest owner instruction: preserve ALL existing Sites/files; do not delete them.

## Execution rules
Complete bounded tickets in order; record requirement IDs, revision, actual tests, limitations, release and next task. Never mark a phase complete from code alone. Preserve current public URLs and Site until a verified migration. Owner requests main environment rather than staging: read-only discovery first, protected smoke checks and backup/restore before production replacement; record this deviation without treating unperformed gates as passed.
Samples/drafts remain clearly labelled and noindex until release gates pass. No invented offers/prices/rights/availability/approvals. No payments, actual ads, purchases or unapproved partner integration. DNS/cutover requires a concrete reviewed plan. P6/P7 deferred.
SEO starts in P0/P1, although full editorial/search readiness is P4.

## P0 — Access, compatibility and release foundation (in progress)
- P0-L01: Inventory repository, current live URLs/content and design assets; capture baseline and migration mapping.
- P0-L02: Verify web/CLI PHP, extensions, Composer, database, cron, document root, SSL, resource/storage constraints.
- P0-L03: Prove Laravel 13 + selected Livewire 4 + minimal Filament dependency compatibility.
- P0-L04: Protected Blade homepage/detail/article smoke checks, isolated MySQL CRUD/migration, scheduler, built assets, backup and restore proof.
- P0-L05: Record ADR-001 PASS/FAIL/BLOCKED and exact evidence.
Observed: GitHub read/write verified; Actions SSH preflight succeeded on revision 93ca7a6036737eb7a59b68045b8a276a13d136a2, run 38169173894. CLI PHP 8.4.26, extensions and Composer path observed. This is NOT complete Laravel, web PHP, database, cron or restore proof.
Exit: compatibility, protected checks and rollback evidence pass.

## P1 — Responsive public frontend
- Homepage hero/search and discoverable Activities, Holidays, Visas, Cruises, Yachts, Events.
- Listing/search filters, sort, pagination, query state and empty/error states.
- Category-aware detail pages: gallery, sourced information fields, FAQs, related content and honest CTA states.
- Distinct blog article template and blog hub using shared listing architecture.
- Mobile/desktop, keyboard/accessibility, Blade-delivered metadata and stable URL checks.
Exit: representative screenshots/interactions accepted; labelled noindex samples, feature and browser checks evidenced.

## P2 — Data architecture and editorial CMS
- Product, Variant, Offer, Partner, Location, Article and SourceEvidence boundaries.
- Database migrations, relationships, validation and minimal Filament editing.
- Draft/review/publication workflow, roles, audit history, media rights and source freshness.
Exit: one product supports multiple offers; only authorized publication reaches public content; migration/validation/restore checks pass.

## P3 — Approved affiliate workflows
- Verify partner permissions and sourcing channel per partner.
- Deep links/adapters, multiple offers, disclosures and sourced price/availability states.
- Outbound attribution, broken-link/freshness monitoring and safe fallback.
Exit: only verified approved links/claims live; outbound click never labelled completed sale.

## P4 — SEO, blogging and AdSense readiness
- Canonicals, crawl rules, selective sitemap, eligible schema, social metadata and internal links.
- Dubai/UAE intent clusters, sourced original articles, author/dates and editorial QA.
- GSC read-only monitoring; verified-page indexability release gates.
- Privacy/disclosures, consent and ads.txt/placement readiness where applicable.
Exit: technical crawl, editorial and policy evidence; separate applicable clearance before actual ads or indexing release.

## P5 — Launch and growth operations
- Verified production release, URL continuity, backup/rollback and health monitoring.
- Analytics/referral reporting, content cadence and monetization reporting from actual evidence.
- Bounded scheduled work with requirement verification and honest per-run logs.
Exit: production checks pass, incident responsibility and rollback proven; no ranking/revenue guarantees.

## P6 — Dubai OTA (deferred)
Separate authorization and legal/commercial/technical feasibility before booking, orders, payment, inventory, cancellations/refunds or customer accounts.

## P7 — Country-by-country expansion (deferred)
Prove Dubai model first; authorize each country's supplier, legal, language/currency and support readiness separately.

## Next bounded package
Finish P0 runtime/dependency and production-baseline preparation. See CURRENT_PLAN.md and RUN_LOG.md for current execution status. Hourly development may continue authorized preparation and CI checks; full production release remains gated.
