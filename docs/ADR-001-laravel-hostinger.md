# ADR-001: Laravel 13 on Hostinger Premium

- Decision ID: ADR-001
- Status: BLOCKED
- Date: 12 October 2026
- Scope: P0-L05 architecture and hosting feasibility gate
- Authority: Master Requirements V3.1 section 25.3 (P0-T05) and AI Execution Playbook V4.1 section 2A.3 (P0-L05)

## Context

The owner selected Laravel 13, Blade server-rendered public pages, selective Livewire 4 and Alpine.js, Tailwind CSS, MySQL/MariaDB, and a minimal compatible Filament editorial workflow. GitHub is the versioned source of truth and Hostinger Premium is the preferred initial runtime.

The prior BookOrGo prototype is not an implementation source. Existing Sites, files, audience, public URLs, and production content must remain untouched until an explicit, reviewed cutover. This record evaluates feasibility evidence only; it does not authorize a deployment, migration, DNS change, indexation change, partner integration, advertising, payment flow, or purchase.

## Decision

Retain the owner-selected Laravel architecture and Hostinger Premium as the preferred target. The observed evidence does not justify reopening framework selection or moving to VPS.

The overall decision is **BLOCKED**, not FAIL. Laravel 13, Livewire 4, Filament, the Hostinger PHP/extension surface, HTTPS origin, CI-rendered Blade/SEO/assets/scheduler smoke package, CI MariaDB CRUD harness, and a protected Hostinger filesystem restore cycle have all produced positive bounded evidence. However, P0 cannot pass and P1 scaffold promotion cannot begin until the remaining Hostinger-specific database, scheduler, durable-storage, protected HTTP/browser, and production rollback gates are proven.

No production deployment is approved by this ADR.

## Evidence matrix

| ID | Gate | Status | Evidence and boundary |
| --- | --- | --- | --- |
| COMPAT | Laravel 13 + Livewire 4 + minimal Filament dependency resolution | PASS | [Run 38194341523](https://github.com/bookorgo/BookOrGo/actions/runs/38194341523); resolved Laravel 13.35.0, Livewire 4.4.7, Filament 5.10.1. |
| HOST-CLI | Host CLI PHP, Composer, extensions, document-root writability | PASS | [Run 38169812198](https://github.com/bookorgo/BookOrGo/actions/runs/38169812198); CLI PHP 8.4.26 and Composer 2.9.8. This does not prove web PHP or database access. |
| HOST-WEB | Web PHP, HTTPS origin, SSL and bounded upload | PASS | [Run 38202823303](https://github.com/bookorgo/BookOrGo/actions/runs/38202823303); web PHP 8.3.35 on LiteSpeed, required probe extensions, valid HTTPS and 1 KiB upload. Web and CLI PHP versions differ. |
| SSR-CI | Blade SSR/SEO HTML, assets and scheduled no-op | PASS_CI_ONLY | [Run 38222473237](https://github.com/bookorgo/BookOrGo/actions/runs/38222473237); three routes, 3 tests/17 assertions, Vite/Tailwind build and scheduler no-op passed only in disposable CI. |
| DB-CI | MySQL/MariaDB migration and CRUD harness | PASS_CI_ONLY | [Run 38217201832](https://github.com/bookorgo/BookOrGo/actions/runs/38217201832); MariaDB 11.4.13 CRUD and cleanup passed only in disposable CI. |
| FS-RESTORE | Protected filesystem archive/restore/checksum/cleanup | PASS_FILESYSTEM_ONLY | [Run 38227821932](https://github.com/bookorgo/BookOrGo/actions/runs/38227821932); only a generated test payload in a unique protected temporary path was touched. This is not a database or application rollback proof. |
| HOST-DB | Actual isolated Hostinger MySQL/MariaDB migration and CRUD | BLOCKED | Requires six dedicated `BOOKORGO_P0_DB_*` GitHub secrets for an isolated smoke database. No unknown or production database may be reused. |
| DB-RESTORE | Hostinger MySQL/MariaDB backup and restore | BLOCKED | Depends on the dedicated isolated smoke database and a guarded database restore procedure. |
| HOST-SCHEDULER | Observable hPanel scheduler execution | BLOCKED | Shell `crontab` is unavailable and does not prove hPanel scheduler absence. A harmless scheduled marker and observable run evidence are still required. |
| DURABLE-STORAGE | `storage:link` or an approved durable public-upload path | BLOCKED | Host file permissions and a small HTTP upload passed, but Laravel public-storage behavior and durable media recovery have not been tested. |
| HOST-HTTP | Protected Laravel HTTP smoke pages and browser screenshots on Hostinger | BLOCKED | Blade HTML passed in CI only. A protected, non-production host path and desktop/mobile browser evidence are still required. |
| PROD-ROLLBACK | Reviewed production release and rollback | NOT_RUN | Production replacement, backup, deployment, DNS, canonical/robots and public indexation changes are outside this decision and require explicit review. |
| ASSET-RIGHTS | Rights-verified logo, fonts and reusable production media | BLOCKED | Design references are layout guidance only. Asset provenance and owner visual signoff remain release gates. |

The machine-readable equivalent is `docs/evidence/ADR-001.json` and is validated by `.github/scripts/validate-adr-001.py`.

## Consequences

- Keep Laravel 13 + Blade SSR + selective Livewire 4/Alpine.js + Tailwind + MySQL/MariaDB + minimal compatible Filament.
- Treat Hostinger web PHP 8.3.35 as the effective application compatibility floor unless a reviewed host change aligns it with CLI PHP 8.4.26.
- Build frontend assets in GitHub Actions because Node/npm were not observed in the Hostinger shell.
- Do not rely on Redis, persistent queue workers, root access, or shell `crontab` on Premium.
- Do not promote the disposable P0 scaffold into the application tree or begin P1 implementation until the required P0 host gates pass.
- Do not propose VPS or another architecture without a reproducible blocker and owner approval.

## Smallest remediation path

1. Configure a dedicated isolated Hostinger smoke database through the six recorded GitHub secrets and run the guarded P0-L04a host job.
2. Prove database export and restore only against that isolated database.
3. Configure an hPanel scheduler entry for a harmless observable Laravel/no-op marker and capture execution evidence.
4. Prove `storage:link` or an approved durable media path, backup and restore.
5. Deploy the already-defined smoke application only to a protected new host path, collect real HTTP and desktop/mobile evidence, then remove it without changing existing production files or URLs.
6. Re-evaluate ADR-001. PASS requires all mandatory gates; FAIL requires a reproducible incompatibility and the smallest owner-approved exception path.

## Rollback and safety

This record changes documentation and validation only. Rollback is the Git revert of the ADR package. It makes no Hostinger, database, DNS, Site audience, canonical, robots, ads, affiliate, payment, or production-content change.
