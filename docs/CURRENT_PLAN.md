# Current execution plan

## P1-DESIGN-FIDELITY — source checkpoint, 14 October 2026
Owner rejected the prior match again. Continuing three-template visual correction: self-hosted credited UAE photos and bundled OFL Inter, eight-tile lower homepage, four-column footer, compact single-choice filter lists and query-preserving sorting, honest empty review/date/photo sections. See docs/P1_DESIGN_FIDELITY.md and media register. Local npm clean install/production build, JS syntax and whitespace checks passed. PHP/browser CI and deployment pending; previous verified live release remains 001b5ed75c77f26f2267bfbb001931bb3b37df31. No database/DNS/commercial/indexing changes. Exact reference photography/content and owner visual acceptance are not established.


## P1-DESIGN-MATCH — verified live correction, 13 October 2026
Release `001b5ed75c77f26f2267bfbb001931bb3b37df31` is verified live at https://bookorgo.com; guarded run https://github.com/bookorgo/BookOrGo/actions/runs/38436156850 succeeded. Tested source b83e827831a7dbdadcac5af644d0f3cc88add116; CI run 38435614659. 18 tests / 393 assertions, Chromium 1920/1440/768/390/320, no-JS 27 links, filters/sort/pagination/FAQ passed. Live: 34 HTTP/security/asset checks, zero failures; 1440/390 browser flows, no page errors or horizontal overflow. Screenshots reviewed. Backup/extracted restore comparison passed; original default.php and previous release retained; no database operation. Rollback was available but not needed.
The initial corrected build f5da73b failed tablet overflow; screenshot review found search/header stacking. Both were fixed before deployment. Prior design acceptance was explicitly rejected by the owner; this release is a layout correction, NOT an exact/pixel-identical design acceptance. Photographs, verified font assets, live offer/review content and owner acceptance remain open. Samples/noindex and disabled dates/travellers remain. Next: P1-05 accessibility/cross-browser QA and remaining reference differences; obtain rights-verified imagery/font assets before claiming full visual equivalence. Independent authorized tasks remain, so the schedule is not paused.

## Owner rejection and correction — P1-DESIGN-MATCH
On 13 October the owner explicitly rejected the prior visual match. Earlier implementation/deployment passes do not establish design acceptance. Priority is correcting homepage, listing and detail geometry against the supplied 1920px screenshots. Changes restore a compact utility header, lowercase wordmark, overlapping segmented search, circular hero artwork, compact result rows/sort tabs and seven-panel detail gallery. Samples/noindex remain; unsupported dates/travellers stay disabled. Rights-verified photographs, exact font provenance, real offers/reviews and owner visual acceptance remain unavailable. This is a correction, not a pixel-identical completion claim.

## Latest owner design correction — 13 October 2026
Owner requested completion of the three reference-led designs and live deployment. P1-DESIGN-02/03 are implemented and verified live at `14a68ed92047aa0bebe657e87fe3bc32a9fd0b5b`; run 38405846968 attempt 2 passed. The combined release also deployed P1-04 draft journal/articles and five honest information/policy placeholders. See P1_DESIGN_RELEASE.md. All samples stay labelled/noindex; original vector placeholders are not venue photographs. No real offer, price, review, newsletter collection, account, ad or partner action is active. Next: P1-05 broader accessibility/performance/cross-browser QA and owner visual review, then independent P2 data/CMS work when applicable access is ready. Earlier next-package wording below is historical.

## Controlling latest owner decision — OWNER-20261012-MAIN
See OWNER_MAIN_ONLY.md. The owner explicitly reconfirmed main-only incremental development and rejected temporary Hostinger database/staging prerequisites. Begin independent P1 Laravel implementation now; do not run destructive smoke tests against the main database. CI testing remains required, backups/rollback remain required for live changes, and unperformed host checks remain unverified. The older P0-before-P1 stop wording below is historical and superseded for independent feature work.

Updated: 13 October 2026, Asia/Karachi.
Repository: bookorgo/BookOrGo. Fresh application, not an import from the previous prototype.
Controlling owner decisions: GitHub + Hostinger Premium; main environment requested, no separate staging requested; preserve ALL existing Sites/files. No deletion or overwriting existing application files. Prepare fresh app outside existing document root until a reviewed release/cutover.
Follow PHASE_ROADMAP.md. Private original Master Requirements V3.1, Playbook V4.1, kickoff and approved reference PDFs remain the authority. Retrieve them from owner Library; never publish full internal documents to this public repository.

## Current status
P0 operational checks remain open where relevant. P1-01 through P1-04 and the previous reference-led homepage/listing/detail implementation (visual match subsequently rejected) are verified live on main Hostinger at `14a68ed92047aa0bebe657e87fe3bc32a9fd0b5b`. 18 tests / 393 assertions, 34 live HTTP/security/asset checks and desktop/mobile browser verification passed. Full P1 acceptance remains open pending wider QA and owner review. P2-P5 not started; P6-P7 deferred.
Completed bounded package P0-L02a: GitHub Actions SSH, CLI PHP and tooling inventory.
Evidence: https://github.com/bookorgo/BookOrGo/actions/runs/38169812198
Tested code revision: abbc16c6e34b1d7cb75555529065f13948053f25
Observed PHP 8.4.26, Composer 2.9.8 running under PHP 8.4, memory limit 512M, required extension probe missing list empty. git/tar/unzip/mysql/mariadb/mysqldump available. node/npm/crontab unavailable in this shell. Document-root directory exists and is writable.
This does not prove database authentication/version, hPanel cron availability, web PHP, SSL/origin routing, dependencies, backups or restore.
Workflow .github/workflows/hostinger-preflight.yml is read-only, uses HOSTINGER_SSH_KEY and HOSTINGER_KNOWN_HOSTS, and runs on its changes on main or manual dispatch. Strict host checking required. Secrets must never be printed. GitHub connector supports repo writes and run-log reads; direct dispatch is not exposed. Supported push triggers can run checks.
Assets should be built in CI if hosting Node is unavailable. Cron requires hPanel capability verification; absent crontab is not proof hPanel scheduling is unsupported.

## Latest bounded inventory — P0-L01a
Completed read-only inventory; see P0_BASELINE.md and evidence/P0-L01a-baseline.json.
Verified 12 October 2026 01:06 UTC: public homepage returns 200 with title Default page, no canonical or noindex signal detected, no discovered category links; robots.txt is 200 with no non-comment directives; sitemap.xml is 404. Host document root has one file/default.php marker. This differs from historical Site observations; cause and DNS routing were not verified. Existing Site/files were preserved.
Tested revision aa64f9b55a60ee1fc7502f0a8014606dfcf792c3; Actions run 38190560434 passed.

## Latest bounded design and URL inventory — P0-L01b
Completed the remaining P0-L01 design/asset and prior-URL inventory; see P0_DESIGN_URL_MANIFEST.md and evidence/P0-L01b-design-url-manifest.json.
Rendered and visually inspected all six pages across the three owner reference PDFs. Recorded structural guidance for fresh homepage, listing, detail and blog templates while excluding third-party branding, content, prices, reviews and media.
Loaded all 21 observed public ChatGPT Site routes: every route exposed `noindex,nofollow`, and none exposed a canonical tag. Three query-string filter states were recorded separately from canonical route candidates. The earlier Site remains a path reference only; no old code, copy, records or assets will be imported.
Asset release blockers are explicit: no separate rights-verified logo original, font licence register or reusable-media provenance was verified. P0-L01 is complete at inventory level; asset approval remains an implementation/release gate.
No Site, Hostinger, DNS, audience or indexation setting changed.
Next bounded package: P0-L02b web PHP/origin/document-root/SSL proof and resource/upload constraints.

## Latest bounded Hostinger web-runtime proof — P0-L02b
Completed protected web-runtime, origin, HTTPS and bounded-upload verification; see P0_HOST_RUNTIME.md and evidence/P0-L02b-web-runtime.json.
Successful final run: https://github.com/bookorgo/BookOrGo/actions/runs/38202823303 at tested revision 1bd7fd9eb7c955c83bed6a22facca5beb66cdc90.
Observed web PHP 8.3.35 on LiteSpeed with all required probe extensions, 512M memory, 300-second execution limit, 256M upload/post limits and 20-file upload limit. A real 1 KiB multipart upload passed.
The random POST-only noindex probe proved that the known Hostinger public_html is served at https://bookorgo.com; HTTP redirected 301 to HTTPS, HTTPS returned 200 and the certificate was valid beyond seven days through 31 December 2026. The transient probe was verified removed.
CLI PHP remains 8.4.26, so web and CLI runtimes differ. The verified Laravel 13 family supports PHP 8.3+, but deployed code must not use PHP 8.4-only behavior unless web PHP is deliberately aligned through a reviewed Hostinger change.
No deployment, existing-file replacement, DNS, Site, audience or indexation change occurred.
Limitations: filesystem free space is not the account quota; only a 1 KiB upload was exercised; database, scheduler, storage-link, backup and restore remain open.
The first run 38202643328 failed honestly because the check compared web DOCUMENT_ROOT with a CLI-only HOME value. The corrected comparison passed in runs 38202757487 and 38202823303.

## Latest bounded isolated-database preparation — P0-L04a-prep
Completed and CI-verified the isolated MySQL/MariaDB migration/CRUD/cleanup harness; see P0_ISOLATED_DB_PROOF.md and evidence/P0-L04a-db-harness.json.
Successful Actions run: https://github.com/bookorgo/BookOrGo/actions/runs/38217201832 at tested revision 888f3c624aed1f18bb5ae2120d3e7106b0fd02ef.
On PHP 8.3 and disposable MariaDB 11.4.13, connection, table creation, insert/read/update/delete, table drop and post-run cleanup all passed. Database identity and credentials were not logged.
Hostinger proof remains BLOCKED: the readiness job found no dedicated BOOKORGO_P0_DB_HOST, BOOKORGO_P0_DB_PORT, BOOKORGO_P0_DB_DATABASE, BOOKORGO_P0_DB_USERNAME, BOOKORGO_P0_DB_PASSWORD or BOOKORGO_P0_DB_CONFIRM secret. No Hostinger database connection was attempted.
The Hostinger job is manual-dispatch only, requires an explicitly isolated p0/smoke database name and exact confirmation value ISOLATED_EPHEMERAL_DATABASE, and cannot run from a normal push.
No deployment or production change occurred. Backup/restore remains a separate P0-L04b gate.

## Latest bounded Blade/SEO, asset and scheduler preparation — P0-L04b-prep
Completed a disposable PHP 8.3 Laravel smoke package for protected Blade SSR/SEO HTML, built assets and scheduled no-op execution; see P0_BLADE_SCHEDULER_SMOKE.md and evidence/P0-L04b-blade-scheduler.json.
Successful Actions run: https://github.com/bookorgo/BookOrGo/actions/runs/38222473237 at tested revision f652ee1ea235b6aebd2d97520e6720a6ad28127b.
The clean build resolved Laravel Framework 13.35.0, Livewire 4.4.7 and Filament 5.10.1 on PHP 8.3.35. Vite/Tailwind production assets built successfully. Three protected routes—homepage, activity detail and blog article—returned server-rendered HTML; 3 feature tests and 17 assertions verified status 200, unique titles/H1 content, canonical URLs, noindex,nofollow, all six planned category labels, no live offer and the article publication gate.
The named every-minute no-op schedule executed and produced a timestamped proof file. Artifact 11735210224 retained seven evidence files with digest sha256:27119fbf88dc72c6b7bfc1bba099178138a8f5bb73f95a343697fe87e4cbc2c9.
Two earlier runs failed honestly: 38222038879 treated intentional exact package pins as strict validation warnings; 38222285085 exposed the default database cache-lock dependency. The final run uses normal Composer schema validation and an isolated in-memory cache for the disposable scheduler proof.
Status is PASS_CI_ONLY, not a Hostinger or release pass. No deployment occurred. Hostinger scheduler configuration, protected browser screenshot, storage link, database backup/restore and actual host database proof remain open.

## Latest bounded Hostinger filesystem restore proof — P0-L04c-fs-restore
Completed a protected Hostinger filesystem backup/restore/checksum/HTTP-denial/cleanup proof; see P0_HOST_FILESYSTEM_RESTORE.md and evidence/P0-L04c-host-filesystem-restore.json.
Successful Actions run: https://github.com/bookorgo/BookOrGo/actions/runs/38227821932 at tested revision 1cb06b2f3535b1a9e2978df4ef9e6b726ec7124f.
A unique mode-700 temporary path under the known document root contained only a generated test payload and deny-access file. The payload was archived, the source removed, the archive allowlisted, and the payload restored to a separate directory. Source and restored SHA-256 values matched. Direct HTTPS access returned 404.
Final cleanup removed every known temporary file and directory. The document-root top-level name/type fingerprint after cleanup exactly matched the pre-test fingerprint. Existing file contents opened: zero; database touched: false; deployment: none.
Status is PASS_FILESYSTEM_ONLY. This proves the host can perform a guarded file archive/restore cycle; it is not a MySQL restore, full Laravel release rollback or hPanel Scheduler proof. Database backup/restore remains gated by dedicated isolated DB inputs, and scheduled execution remains gated by observable hPanel cron configuration.
Artifact 11737430400 digest: sha256:f31d389ca1d3f3694568ff496295e7e1fef0b2cb0adac7ef4da61ee1c6e39369.

## Latest architecture decision — P0-L05 / ADR-001
Recorded and machine-validated ADR-001 as BLOCKED; see ADR-001-laravel-hostinger.md and evidence/ADR-001.json.
Successful initial validation: https://github.com/bookorgo/BookOrGo/actions/runs/38234390686 at decision revision c60a56724e43593f4f250615bcfa50e61e0b9f1a. Successful checkpoint validation: https://github.com/bookorgo/BookOrGo/actions/runs/38234543176 at revision 9b2b4bedcaeacfcaab268b205d0864f71b1df2ed.
The owner-selected Laravel 13 + Blade SSR + selective Livewire 4/Alpine + Tailwind + MySQL/MariaDB + minimal compatible Filament architecture remains the preferred stack, and Hostinger Premium remains the preferred target. Existing positive evidence covers dependency resolution, host CLI/web PHP and extensions, HTTPS/origin, CI Blade/SEO/assets/scheduler smoke checks, CI MariaDB CRUD, and a protected Hostinger filesystem restore cycle.
P0 is not PASS. The later P1-01 release supplied protected Hostinger Laravel HTTP and desktop/mobile browser evidence for the database-independent shell. Remaining mandatory operational gates are main-database configuration/CRUD when introduced, MySQL backup/restore, observable hPanel scheduler execution, Laravel durable storage/public-media recovery and rights-verified production assets. No VPS or stack change is proposed from current evidence.
No production deployment, DNS, Site audience, canonical/robots, ads, affiliate, payment or existing-file change occurred.

## Latest bounded dependency proof — P0-L03
Completed a clean, disposable Laravel compatibility build in GitHub Actions; no production or Hostinger files were changed.
Tested revision: 6f7a177f67438c91c2ad68ca125a0eee1cc96f2a.
Evidence: https://github.com/bookorgo/BookOrGo/actions/runs/38194341523 and docs/evidence/P0-L03-compatibility.json.
Resolved on PHP 8.4.26 with Composer 2.10.3: Laravel Framework 13.35.0, Livewire 4.4.7 and Filament 5.10.1. Composer validation, package discovery, route listing, SQLite migration, two starter tests, npm clean install and production Vite/Tailwind build passed. The Laravel distribution did not include package-lock.json, so the first CI attempt failed honestly at npm ci; the workflow now generates a frontend lockfile before the clean install and the rerun passed.
Mapped requirements: Master Requirements V3.1 section 25.1; Playbook V4.1 sections 2A.2 and P0-L03.
Limitations: generated Composer/npm lockfiles are retained as CI evidence but are not yet promoted as the repository application scaffold; MySQL/MariaDB, Filament panel creation, host web runtime, scheduler, backup/restore and deployment remain unverified. Dependency security audits were not part of this bounded proof.


## Latest application package — P1-01 homepage foundation
Fresh actual Laravel application is now in `site/`. Tested revision f8a1c71403dcf1c5473542ffa395af1b6cc60d8f; successful workflow https://github.com/bookorgo/BookOrGo/actions/runs/38249192582. Five feature tests / 65 assertions, locked PHP 8.3 install, production Vite build, route/view/config cache and Chromium checks at 1440/768/390/320 passed. JS-disabled navigation/search and eight internal link targets passed. Desktop/tablet/mobile screenshots reviewed. See P1_FOUNDATION.md and evidence/P1-01-foundation.json.
The old PHP 8.4 Composer lock was not compatible with Hostinger web PHP 8.3.35; the corrected committed lock pins the Composer platform and uses Symfony 7.4 while retaining Laravel 13.35.0, Livewire 4.4.7 and Filament 5.10.1.
Status: foundation slice CI-verified and live on Hostinger at release revision 6e091e2502f0547c0d5213da1ae2b11a25915dc8. P1 as a phase remains incomplete. Pages are labelled development previews/noindex with category-only search, empty category states and no fake inventory. No database or scheduler was used. See P1_MAIN_RELEASE.md and evidence/P1-01-main-release.json.

## Latest main release — P1-01-main-release
Guarded production workflow run https://github.com/bookorgo/BookOrGo/actions/runs/38288802464 verified the exact release revision 6e091e2502f0547c0d5213da1ae2b11a25915dc8. CI build/tests, strict SSH preflight, package allowlist, PHP 8.4 host dependency check, document-root backup plus restore-check, activation and live browser/security verification all passed.

Nine intended HTML routes returned 200 with one H1, correct canonical URL and HTML plus HTTP `noindex, nofollow`. CSS and JavaScript assets returned 200 with expected MIME types. Unknown routes returned 404; sensitive `.env`, source, vendor and log probes were denied or absent. Desktop 1440 px and mobile 390 px browser flows, search, mobile menu and horizontal-overflow checks passed with zero page errors. The original `default.php` was preserved, application source/vendor remained outside the web root, and no database operation occurred.

The first workflow attempt failed before host access because tests preceded the Vite build. The second activated successfully but detected inaccessible asset permissions, then automatically rolled back only the newly introduced files and restored the one-file baseline. Neither failure was reported as live. The corrected third run finalized successfully. Draft/noindex protection remains in force; this was not an SEO indexability release.

## Latest main release — P1-02-main-release
Guarded production upgrade run https://github.com/bookorgo/BookOrGo/actions/runs/38360967725 verified and released exact revision `953665b8db816d7580d025e67fe7d39771078ed8` from the previously verified P1-01 revision. The preflight matched the exact current-release marker and public file baseline before any mutation. A full document-root archive and extracted restore comparison passed before activation; the original `default.php` remained preserved and the database was not touched.

Build/tests passed with 8 feature tests / 159 assertions. Twenty bounded live HTTP/security checks passed across homepage, six category listings, keyword search, filtered result, pagination, blog, safe 422/404 behavior, sensitive path denial/absence and built assets. Desktop 1440 px and mobile 390 px live browser checks passed listing, filters, mobile menu, filtered navigation, pagination and overflow with zero page errors. The release was finalized and its incoming archive removed; rollback was not required. All sample cards remain explicit fictional demonstrations and meta plus HTTP `noindex, nofollow` remains in force.

## Latest application package — P1-03 detail templates
Completed the bounded category-aware detail package at tested revision `210fd669d94dbdff378fceb91fe94a17dc770865`; successful workflow https://github.com/bookorgo/BookOrGo/actions/runs/38368020406. Eleven feature tests / 304 assertions, locked PHP 8.3 install, production Vite build, route/view/config caches and Chromium checks at 1440/768/390/320 passed.

Implemented 18 unique stable sample-detail URLs through one shared Blade template with six category variants. Activity, holiday, visa, cruise, yacht and event pages expose their required field names but truthfully mark values as not supplied. Pages include breadcrumb navigation, related samples, original CSS placeholder artwork, category-specific source/review notes and disabled referral actions. Visa pages state that the preview is not immigration advice. All records remain fictional, labelled and protected by meta plus HTTP `noindex, nofollow`; there are no partner, price, schedule, availability, rating or booking claims.

Desktop/mobile detail screenshots were visually reviewed with no blocking hierarchy, clipping, disclosure or overflow defect. Artifact `11798225091`, digest `sha256:1fa60d490aad87a8dd81f702bc12675e3935ee7695fa291ae8c250e7c3df2fbf`, expires 27 October 2026. See P1_DETAIL.md and evidence/P1-03-detail.json.

Status: PASS_CI_DETAIL_SLICE. The later guarded P1-03 main release deployed this exact detail implementation at release revision `38c14eddb86c76f909354629e1f4bd4fcd730f12`. Safari/Firefox, full WCAG/performance, owner visual acceptance, real sourced records, CMS and partner actions remain outside this package.

## Latest main release — P1-03-main-release
Guarded production upgrade run https://github.com/bookorgo/BookOrGo/actions/runs/38374158337 verified and released exact revision `38c14eddb86c76f909354629e1f4bd4fcd730f12` from the previously verified P1-02 revision `953665b8db816d7580d025e67fe7d39771078ed8`. Exact current-release and public-baseline checks passed before mutation. A full public-root backup plus extracted restore comparison passed before activation; `default.php` remained preserved and the database was not touched.

Build/tests passed with 11 feature tests / 304 assertions. Twenty-six live HTTP/security checks passed with zero failures across the homepage, six listings, three search/filter/pagination states, blog, six representative detail variants, safe 422/404 behavior, sensitive path denial/absence and built assets. Intended pages retained one H1, exact canonical and meta plus HTTP `noindex, nofollow`. Chromium at 1440 px and 390 px passed homepage, listing, detail, filters, navigation, pagination, mobile menu and overflow checks with zero page errors. Live detail screenshots were visually reviewed with no blocking defect.

Release archive: 13,051,493 bytes, SHA-256 `d9d734705da5e90c355b6556b10e306fb69df44ffaee6da9eb4c6ffa23b5f3da`. Backup SHA-256: `6efb4775db7e386e102bd14d9e02b8bd9e3c423cfae34dc8b75e7a45a122cdb5`. Finalization wrote the verified-live marker and removed the incoming archive; rollback was available but not required. All detail content remains labelled fictional demonstration data with disabled actions and no price, availability, partner or booking claim. See P1_DETAIL_RELEASE.md and evidence/P1-03-main-release.json.

## Latest application package — P1-04 journal and article templates
Completed the bounded draft journal/article package at tested revision `8ad99e9e776aa13d3396c131f445b508e1d015a5`; successful workflow https://github.com/bookorgo/BookOrGo/actions/runs/38395407380. Fourteen feature tests / 337 assertions, locked PHP 8.3 install, Vite/Tailwind build, route/view/config caches and Chromium checks at 1440/768/390/320 passed.

Implemented a journal hub with three stable draft article URLs and one shared article template. The template includes breadcrumb/H1, summary, withheld author/date states, original placeholder artwork, at-a-glance panel, TOC, source register, commercial disclosure, inactive ad area and contextual links to fictional detail samples. No factual travel guide, author, date, source, social image right, editorial schema, ad or affiliate link is claimed.

Desktop/mobile article screenshots were visually reviewed with no blocking hierarchy, disclosure, inactive-ad, clipping or overflow defect. Artifact `11811816142`, digest `sha256:fd90d2926ac9f144f9c57b436baad540ba699323532da2bccd1d85c7f2d21d8b`, expires 27 October 2026. See P1_ARTICLE.md and evidence/P1-04-article.json.

Status: PASS_CI_ARTICLE_SLICE. Deployment was not performed; production remains on P1-03 revision `38c14eddb86c76f909354629e1f4bd4fcd730f12`. Safari/Firefox, full WCAG/performance, mobile live-ad behavior, real sourced content/CMS and owner visual acceptance remain outside this package.

## Ordered next tasks
1. P1-04-main-release: extend the guarded current-release workflow for exact P1-03 preflight, backup/restore comparison, bounded activation/rollback and live journal/article/security/browser verification.
2. P1-05: wider visual/accessibility QA and owner design review.
3. P2: main application database configuration, normalized catalog/source data, migrations, minimal editorial CMS and publication roles. Database backup/restore is required before relevant main data changes; do not reuse the isolated temporary-table harness on the main database.
4. P3: approved partner sourcing, links/disclosures, attribution and freshness checks.
5. P4: SEO crawl/indexability controls, eligible schema, original editorial content and search monitoring.
6. P5: production operations, rollback/monitoring and growth reporting. Keep unresolved operational P0 evidence honest and address each gate when applicable; it is not a blanket ban on independent feature work.
7. P6/P7 deferred to separate owner authorization.

## Work rules
Take one bounded ready package per scheduled run; continue independent prep when another gate needs owner input. Read latest remote source before editing. Avoid overlapping edits; reconcile remote head and active CI runs. Record task IDs, tested revision, actual test results, honest limitations and next task in RUN_LOG.md.
Samples/drafts labelled and noindex. No fabricated claims/offers/rights/prices/availability. No payments, actual ads, DNS, purchases or unapproved integrations. Do not alter existing Site audience. No copied prototype code.
If every authorized task is blocked, report exact input and pause rather than repeat no-op runs. Hourly scheduling is discrete runs, not an always-on process.
