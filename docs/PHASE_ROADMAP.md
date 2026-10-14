# BookOrGo phase roadmap

## P1-05a — completed cross-browser/accessibility audit, 14 October 2026
Source `3ad8b9bb003e36a85cf1d22d3275235fc2a26b03`; successful read-only workflow https://github.com/bookorgo/BookOrGo/actions/runs/38514992538. Chromium, Firefox and WebKit at 1440/390 checked homepage, listing, detail and article: 24 page states, zero functional failures or page errors. Skip-to-main keyboard focus, mobile menu Enter/Escape/focus restoration, native FAQ, filters/sort query preservation, image decode, canonical/noindex/H1 and overflow checks passed. WebKit mobile screenshot visually inspected; no blocking clipping/overflow. These engines are not physical Safari/iOS/Android device proof.
Automated axe-core 4.10.3 audits found issues in all 24 states, across four rule families: serious target-size on 14px dense listing radios; serious color-contrast on detail Not rated text (#777 on white, observed 4.47:1 vs required 4.5:1); moderate region for preview notice outside landmarks; moderate landmark-complementary-is-top-level on listing/article asides. The moderate landmark findings are best-practice rules, not a blanket WCAG failure. Incomplete color-contrast and aria-prohibited-attr results require manual review. This workflow PASS means the audit and functional checks executed, NOT accessibility compliance.
Artifact 11872175676, digest sha256:564459cdc0e04c7f9b41f7d0434e6f9b5748ddca8f361bc94752ffa2303d5554; full rule/selector evidence in docs/evidence/P1-05a-quality.json. Private owner documents were read but not published. Requirements: Master V3.1 section 19 performance/media/accessibility and Playbook UI-01–UI-05/component behavior acceptance.
Deployment NOT PERFORMED; live release remains 775e77bf827d8de3d7161bc5a3d59995ac065c59. No production source, database, DNS, indexing, commercial, ads, payment or partner state changed. P1 remains incomplete; owner visual acceptance, physical-device/screen-reader checks, performance/CWV and fixes remain. Next P1-05b fixes target-size/contrast and landmark semantics, reruns audits and prepares a guarded release only after passing checks. Lease released; authorized work remains.


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
- P1-01 status: homepage/navigation/search foundation is verified live at revision `6e091e2502f0547c0d5213da1ae2b11a25915dc8`; draft/noindex protection remains. P1 is not complete.
- P1-02 status: listing/filter/sort/pagination and empty/error/loading states are verified live at release revision `953665b8db816d7580d025e67fe7d39771078ed8`; all fictional samples remain labelled and noindex.
- P1-03 status: category-aware detail templates are verified live at release revision `38c14eddb86c76f909354629e1f4bd4fcd730f12`; required values remain withheld and actions disabled.
- P1-04 status: journal hub and draft article template are verified live in combined design release `14a68ed92047aa0bebe657e87fe3bc32a9fd0b5b` (run 38405846968 attempt 2).
- P1-DESIGN-02/03 status: reference-led homepage discovery modules, top listing search/sort, original media/gallery, location/FAQ/referral hierarchy and footer information routes are verified live. Real sourced content, rights-verified media, final legal policies and P1-05 owner/wider QA acceptance remain.
- Homepage hero/search and discoverable Activities, Holidays, Visas, Cruises, Yachts, Events.
- Listing/search filters, sort, pagination, query state and empty/error states.
- Category-aware detail pages: gallery, sourced information fields, FAQs, related content and honest CTA states.
- Distinct blog article template and blog hub using shared listing architecture.
- Mobile/desktop, keyboard/accessibility, Blade-delivered metadata and stable URL checks.
Exit: representative screenshots/interactions accepted; labelled noindex samples, feature and browser checks evidenced.

Next bounded package: P1-05 broader accessibility/performance/cross-browser QA and owner review. Keep every sample labelled and noindex; do not activate commercial or indexing features from design completion alone.

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
Latest owner override, 13 October: reference-design implementation and combined guarded release completed at `14a68ed92047aa0bebe657e87fe3bc32a9fd0b5b`. P1-05 broader QA/owner review is next. See P1_DESIGN_RELEASE.md. Earlier next-package wording below is historical.
P1-04 is CI-verified at `8ad99e9e776aa13d3396c131f445b508e1d015a5` in run 38395407380; see P1_ARTICLE.md. Prepare its guarded main release next, then complete wider P1 visual/accessibility QA and owner review. P1 is not complete; real sourced content, CMS, indexability, ads/affiliate activation and broader QA remain.

## Owner rejection and correction — P1-DESIGN-MATCH
On 13 October the owner explicitly rejected the prior visual match. Earlier implementation/deployment passes do not establish design acceptance. Priority is correcting homepage, listing and detail geometry against the supplied 1920px screenshots. Changes restore a compact utility header, lowercase wordmark, overlapping segmented search, circular hero artwork, compact result rows/sort tabs and seven-panel detail gallery. Samples/noindex remain; unsupported dates/travellers stay disabled. Rights-verified photographs, exact font provenance, real offers/reviews and owner visual acceptance remain unavailable. This is a correction, not a pixel-identical completion claim.


## P1-DESIGN-FIDELITY — verified live, 14 October 2026
Released `775e77bf827d8de3d7161bc5a3d59995ac065c59` to https://bookorgo.com through guarded run https://github.com/bookorgo/BookOrGo/actions/runs/38509065461. Source `c6f4b5f117043b83d3b3c1e307d579fbc3fafd02`, CI 38476477536: 18 tests / 398 assertions, five viewports 1920/1440/768/390/320, 27 JavaScript-disabled internal links, filters/sort/pagination/FAQ/photo/font checks and no page errors. Live: 43 HTTP/security/asset checks, zero failures; 1440/390 browser interactions passed. Exact previous revision preflight, backup/extracted restore comparison and finalization passed; rollback was available but unnecessary. Backup SHA256 5b379ba0f505d8e030fef5dc02da92cdebf065064169dea388e9b6c04e3f5915. Original default.php, previous releases, Sites and URLs preserved; database untouched.
Changes: independently licensed self-hosted destination photos, OFL Inter homepage font, eight-tile lower discovery grid and four-column footer, compact single-choice filters and three-card inspiration strip, seven-panel gallery with unrated summary, empty review sections and disabled date/options layout. Photo credits and provenance register supplied; no invented prices, reviews, rights or availability.
Initial final-home screenshot caught lazy images before decode after a second navigation; first-visit image checks had passed. Added a read-only visual workflow at 2ea555d7f1511ede8521fea2deb93abff18f7841. Run 38509466280 produced clean desktop/mobile captures with all 25 homepage, 9 listing and 10 detail images decoded; zero errors/overflow. Screenshots reviewed. Artifacts: release 11868613104, clean visual 11868803212. Detailed hashes/evidence in docs/evidence/P1-DESIGN-FIDELITY-release.json.
Status: VERIFIED_LIVE_CORRECTION, not pixel-identical completion or owner acceptance. Different licensed photos and fictional content remain; all draft/sample noindex and disabled commercial actions preserved. No DNS, indexing, ads, payments or partner activation. Next P1-05 wider accessibility/performance/cross-browser QA and owner design review. Operational database/cron/storage gates remain open when applicable; P6/P7 deferred. Lease released.
