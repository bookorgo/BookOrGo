# Current execution plan

## Controlling latest owner decision — OWNER-20261012-MAIN
See OWNER_MAIN_ONLY.md. The owner explicitly reconfirmed main-only incremental development and rejected temporary Hostinger database/staging prerequisites. Begin independent P1 Laravel implementation now; do not run destructive smoke tests against the main database. CI testing remains required, backups/rollback remain required for live changes, and unperformed host checks remain unverified. The older P0-before-P1 stop wording below is historical and superseded for independent feature work.

Updated: 12 October 2026, Asia/Karachi.
Repository: bookorgo/BookOrGo. Fresh application, not an import from the previous prototype.
Controlling owner decisions: GitHub + Hostinger Premium; main environment requested, no separate staging requested; preserve ALL existing Sites/files. No deletion or overwriting existing application files. Prepare fresh app outside existing document root until a reviewed release/cutover.
Follow PHASE_ROADMAP.md. Private original Master Requirements V3.1, Playbook V4.1, kickoff and approved reference PDFs remain the authority. Retrieve them from owner Library; never publish full internal documents to this public repository.

## Current status
P0 operational checks remain open. P1-01 homepage/navigation foundation CI-verified under OWNER-20261012-MAIN; main Hostinger publication is next. P2-P5 not started; P6-P7 deferred.
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
P0 is not PASS. Mandatory unresolved gates are an isolated Hostinger database CRUD proof, MySQL backup/restore, observable hPanel scheduler execution, Laravel durable storage/public-media recovery, protected Hostinger Laravel HTTP plus desktop/mobile browser evidence, and rights-verified production assets. No VPS or stack change is proposed from current evidence.
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
Status: foundation slice CI-verified, NOT live on Hostinger. P1 as a phase remains incomplete. Pages are labelled development previews/noindex with category-only search, empty category states and no fake inventory. No database, scheduler or existing production/Site file changed. Main release plan is prepared in P1_MAIN_RELEASE_PLAN.md; do not confuse GitHub main with a deployed main website.

## Ordered next tasks
1. P1-01-main-release: implement the concrete guarded main release/rollback plan in P1_MAIN_RELEASE_PLAN.md for the tested database-independent homepage. Use fresh inventory and the existing SSH connection. No staging or temporary Hostinger database prerequisite. Preserve all current files and the existing Site; no DNS change or indexing release.
2. P1-02: full category-aware listing/filter/sort/pagination and state handling; current search is taxonomy-only.
3. P1-03: six category-aware detail variants with clearly labelled samples and honest CTA states.
4. P1-04: reusable blog article layout and listing reuse; then P1-05 wider visual/accessibility QA and owner design review.
5. P2: main application database configuration, normalized catalog/source data, migrations, minimal editorial CMS and publication roles. Database backup/restore is required before relevant main data changes; do not reuse the isolated temporary-table harness on the main database.
6. P3: approved partner sourcing, links/disclosures, attribution and freshness checks.
7. P4: SEO crawl/indexability controls, eligible schema, original editorial content and search monitoring.
8. P5: production operations, rollback/monitoring and growth reporting. Keep unresolved operational P0 evidence honest and address each gate when applicable; it is not a blanket ban on independent feature work.
9. P6/P7 deferred to separate owner authorization.

## Work rules
Take one bounded ready package per scheduled run; continue independent prep when another gate needs owner input. Read latest remote source before editing. Avoid overlapping edits; reconcile remote head and active CI runs. Record task IDs, tested revision, actual test results, honest limitations and next task in RUN_LOG.md.
Samples/drafts labelled and noindex. No fabricated claims/offers/rights/prices/availability. No payments, actual ads, DNS, purchases or unapproved integrations. Do not alter existing Site audience. No copied prototype code.
If every authorized task is blocked, report exact input and pause rather than repeat no-op runs. Hourly scheduling is discrete runs, not an always-on process.
