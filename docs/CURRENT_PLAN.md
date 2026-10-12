# Current execution plan
Updated: 12 October 2026, Asia/Karachi.
Repository: bookorgo/BookOrGo. Fresh application, not an import from the previous prototype.
Controlling owner decisions: GitHub + Hostinger Premium; main environment requested, no separate staging requested; preserve ALL existing Sites/files. No deletion or overwriting existing application files. Prepare fresh app outside existing document root until a reviewed release/cutover.
Follow PHASE_ROADMAP.md. Private original Master Requirements V3.1, Playbook V4.1, kickoff and approved reference PDFs remain the authority. Retrieve them from owner Library; never publish full internal documents to this public repository.

## Current status
P0 in progress. P1-P5 not started in this fresh application; P6-P7 deferred.
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

## Latest bounded dependency proof — P0-L03
Completed a clean, disposable Laravel compatibility build in GitHub Actions; no production or Hostinger files were changed.
Tested revision: 6f7a177f67438c91c2ad68ca125a0eee1cc96f2a.
Evidence: https://github.com/bookorgo/BookOrGo/actions/runs/38194341523 and docs/evidence/P0-L03-compatibility.json.
Resolved on PHP 8.4.26 with Composer 2.10.3: Laravel Framework 13.35.0, Livewire 4.4.7 and Filament 5.10.1. Composer validation, package discovery, route listing, SQLite migration, two starter tests, npm clean install and production Vite/Tailwind build passed. The Laravel distribution did not include package-lock.json, so the first CI attempt failed honestly at npm ci; the workflow now generates a frontend lockfile before the clean install and the rerun passed.
Mapped requirements: Master Requirements V3.1 section 25.1; Playbook V4.1 sections 2A.2 and P0-L03.
Limitations: generated Composer/npm lockfiles are retained as CI evidence but are not yet promoted as the repository application scaffold; MySQL/MariaDB, Filament panel creation, host web runtime, scheduler, backup/restore and deployment remain unverified. Dependency security audits were not part of this bounded proof.

## Ordered next tasks
1. P0-L01 completed at inventory level (P0-L01a baseline and P0-L01b design/asset/URL manifest). Rights-verified production assets remain a release gate.
2. P0-L02a/P0-L02b completed for CLI tooling plus web runtime/origin/SSL/bounded-upload evidence. Web PHP 8.3.35 versus CLI 8.4.26 remains an ADR/release constraint; account quota is still unknown.
3. P0-L04a-prep complete: CI harness passed. Actual Hostinger database proof remains BLOCKED on the six recorded dedicated smoke-database secrets; never reuse an unknown production DB.
4. P0-L04b-prep and P0-L04c filesystem proof completed: protected Blade SSR/SEO, built assets, scheduled no-op CI and guarded Hostinger file restore passed. Hostinger hPanel scheduler, storage-link, isolated MySQL host CRUD and database backup/restore remain required before P0 exit.
5. P0-L05: ADR-001 with PASS/FAIL/BLOCKED; no full P0 PASS until every required gate passes.
6. Promote the P0-L03 verified Laravel 13.35.0, Livewire 4.4.7 and Filament 5.10.1 scaffold and lockfiles only in a dedicated package after the host gates above.
7. P1: homepage/navigation; listing/filter/pagination; six category detail variants; blog article/hub; responsive and accessibility QA.
8. P2: normalized catalog/source data; migrations; minimal editorial CMS; roles/publication workflow.
9. P3: approved partner sourcing; deep links/disclosures; attribution and freshness checks.
10. P4: SEO crawl/indexation controls; eligible schema; editorial content; search monitoring and monetization readiness.
11. P5: release verification/rollback; analytics; ongoing content and operational checks.
12. P6/P7 deferred to separate owner authorization.

## Work rules
Take one bounded ready package per scheduled run; continue independent prep when another gate needs owner input. Read latest remote source before editing. Avoid overlapping edits; reconcile remote head and active CI runs. Record task IDs, tested revision, actual test results, honest limitations and next task in RUN_LOG.md.
Samples/drafts labelled and noindex. No fabricated claims/offers/rights/prices/availability. No payments, actual ads, DNS, purchases or unapproved integrations. Do not alter existing Site audience. No copied prototype code.
If every authorized task is blocked, report exact input and pause rather than repeat no-op runs. Hourly scheduling is discrete runs, not an always-on process.
