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
