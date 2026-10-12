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
