# Run log

## 12 October 2026 — P0-L02a
Owner direction: start a brand-new Laravel application, preserve every existing Site/file, continue in phases with hourly cloud work.
Changed: read-only preflight workflow now checks explicit PHP 8.4 extensions, Composer under PHP 8.4, host tool availability and document-root writability; workflow-file changes on main trigger checks.
Tested revision: abbc16c6e34b1d7cb75555529065f13948053f25
Result: PASS for this limited package.
Evidence: https://github.com/bookorgo/BookOrGo/actions/runs/38169812198
PHP 8.4.26; Composer 2.9.8; memory_limit 512M; missing_extensions [].
Available: git, tar, unzip, mysql, mariadb, mysqldump.
Unavailable in shell: node, npm, crontab. Use CI asset builds; verify hPanel cron separately.
Deployment: none. Existing Site/files unchanged.
Unverified: complete dependency resolution, web PHP, database authentication and CRUD, scheduler execution, backup/restore, browser QA.
Next: P0-L01 inventory and P0-L03 clean Laravel dependency/smoke-test package, before P1.
Full internal documents remain in owner Library; public-repo publication was blocked by automatic approval review and was not retried. CURRENT_PLAN.md and PHASE_ROADMAP.md are the public technical work checkpoints.

## 12 October 2026 — P0-L01a
Completed bounded read-only inventory of repo, Hostinger document-root metadata and public homepage/crawl endpoints.
Tested revision: aa64f9b55a60ee1fc7502f0a8014606dfcf792c3.
Actions run https://github.com/bookorgo/BookOrGo/actions/runs/38190560434 succeeded; Python syntax checked.
Findings: homepage 200 title "Default page", no canonical/noindex detected, no discovered category links; robots 200 with no non-comment directives; sitemap 404. Host document root has one file/default.php marker and no subdirectories. See docs/P0_BASELINE.md and docs/evidence/P0-L01a-baseline.json.
Status: PASS for P0-L01a only; full P0-L01/P0 remains incomplete. Existing source was not imported; no deployment, DNS, file deletion or live SEO mutation.
Next: P0-L03 clean Laravel dependency/smoke-test CI; P0-L01b asset/design and prior URL inventory. Database/web runtime/cron/backup/restore remain unverified.

## 12 October 2026 — P0-L03
Completed a bounded clean-stack compatibility proof against Master Requirements V3.1 section 25.1 and Playbook V4.1 sections 2A.2/P0-L03.
Changed: added .github/workflows/laravel-stack-compatibility.yml. It creates a disposable Laravel 13 application, resolves Livewire 4 plus current compatible Filament, validates Composer, runs package discovery/route list/SQLite migration/tests, generates a frontend lockfile, performs npm ci and builds production assets.
Tested revision: 6f7a177f67438c91c2ad68ca125a0eee1cc96f2a.
Successful Actions run: https://github.com/bookorgo/BookOrGo/actions/runs/38194341523.
Result: PASS for P0-L03 only. PHP 8.4.26; Composer 2.10.3; Laravel Framework 13.35.0; Livewire 4.4.7; Filament 5.10.1; Node 22.23.3; npm 10.9.9. Composer validation, package discovery, one-route inspection, SQLite migration, 2 tests/2 assertions and Vite/Tailwind build passed.
Correction evidence: run 38194188891 failed at npm ci because the Laravel distribution did not contain package-lock.json. The workflow was corrected to generate the frontend lockfile before npm ci; no test was retroactively marked passed.
Artifact: p0-l03-compatibility, ID 11722337895, digest sha256:ad72b3ec67615eec5778d2b10991e7adda7b65459b3abdba974cc4075a49d608, expires 11 November 2026. Generated composer.lock SHA-256 60650c7d46c85a9c8f93b894f5bbd633c279b377893d83c022469fb0982e3178; package-lock.json SHA-256 c480419259a7937003bef067df7b8771b53a1e7b7404fc945879fc10167ee893.
Deployment: none. Existing Hostinger and ChatGPT Site files/audience/URLs unchanged.
Limitations: generated scaffold/lockfiles are evidence only and not yet committed as the application; MySQL/MariaDB, Filament panel setup, security audits, web PHP, scheduler, backup/restore and production release remain unverified.
Next: P0-L01b design/asset and prior URL manifest; then P0-L02b/P0-L04 protected host checks.

## 12 October 2026 — P0-L01b
Completed the bounded design/asset and prior-URL manifest against the owner references and current public ChatGPT Site.
Tested repository revision: 99bd461d6a3669b8adfb6edb6d163cc47e2fd20a.
Result: PASS for P0-L01b inventory only; this is not asset approval, content migration or release approval.
Evidence: docs/P0_DESIGN_URL_MANIFEST.md and docs/evidence/P0-L01b-design-url-manifest.json.
Tests: rendered and visually inspected 6/6 pages across the homepage, listing and detail reference PDFs. Loaded 21/21 observed Site routes; all returned a `noindex,nofollow` meta directive and 0/21 exposed a canonical tag. Recorded three query-string filter states separately from canonical route candidates. Evidence JSON parsed successfully and aggregate counts matched its route array.
Requirements checked: Master Requirements V3.1 sections 01–04, 03, 17 and 25; Playbook V4.1 P0-L01 and P1 template inputs; kickoff fresh-build and release-control rules.
Boundaries: the earlier Site was used only to identify paths and information architecture. No old code, copy, records or assets were imported. No Site, Hostinger, DNS, audience or indexation setting changed.
Limitations: a rights-verified original logo, font licence register, reusable-media provenance, custom-domain route parity and final responsive design tokens remain unverified. Third-party reference branding/content/prices/reviews/media are excluded.
Deployment: none; documentation and evidence checkpoint only.
Next: P0-L02b web PHP/origin/document-root/SSL proof and host resource/upload constraints.

## 12 October 2026 — P0-L02b
Completed protected Hostinger web-runtime, origin, HTTPS and small-upload verification against Master Requirements V3.1 section 25.3 P0-T02, Playbook V4.1 sections 2A.2/2A.3 P0-L02 and the kickoff safety boundary.
Tested revision: 1bd7fd9eb7c955c83bed6a22facca5beb66cdc90.
Successful final Actions run: https://github.com/bookorgo/BookOrGo/actions/runs/38202823303.
Result: PASS for this bounded package. The public origin returned HTTPS 200; HTTP redirected 301 to HTTPS; default certificate verification passed and the certificate reported validity through 31 December 2026. The random probe written under the known Hostinger public_html was fetched through bookorgo.com, confirming origin/document-root mapping.
Web runtime: PHP 8.3.35, LiteSpeed SAPI, missing required extensions [], memory_limit 512M, max_execution_time 300, max_input_time 240, max_input_vars 5000, upload_max_filesize/post_max_size 256M, max_file_uploads 20. A real 1 KiB multipart upload passed with PHP error 0 and is_uploaded_file true.
CLI comparison: PHP 8.4.26, CLI SAPI, memory 512M. Web/CLI PHP versions differ; code must remain PHP 8.3-compatible unless the web runtime is deliberately aligned through a reviewed change.
Safety: the probe was POST-only, unique, no-store and noindex; final SSH assertion confirmed the transient directory was removed. No existing file was overwritten or deleted. No deployment, DNS, Site, audience, robots, canonical, sitemap or database change.
Correction evidence: initial run https://github.com/bookorgo/BookOrGo/actions/runs/38202643328 failed because web DOCUMENT_ROOT was compared with a CLI-only HOME value. The corrected comparison passed in run 38202757487 and the final cleanup-verifying run 38202823303. No failed assertion was reported as passed.
Evidence: docs/P0_HOST_RUNTIME.md and docs/evidence/P0-L02b-web-runtime.json.
Limitations: mounted-filesystem free space is not proof of account quota/inodes; configured 256M upload/post limits were observed but only 1 KiB was exercised; HSTS/cipher inventory/auto-renewal, MySQL, scheduler, storage link, backup and restore remain unverified.
Deployment: none.
Next: P0-L04a new isolated database credentials and temporary migration/CRUD proof; do not reuse an unknown or existing production database.
