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

## Ordered next tasks
1. P0-L01: inventory only BookOrGo paths/URLs without deleting or importing old code; record baseline.
2. P0-L03: fresh Laravel 13 dependency resolution and smoke tests in CI; select compatible Livewire 4 and minimal Filament, pin lockfiles. No substantial P1 before P0 proof.
3. P0-L02b: web PHP/origin/document-root/SSL proof and resource/upload constraints.
4. P0-L04a: new isolated database credentials and temporary CRUD/migration proof; never reuse unknown production DB.
5. P0-L04b: scheduler execution evidence, build artifacts, protected Blade smoke views, backup/restore proof.
6. P0-L05: ADR-001 with PASS/FAIL/BLOCKED; no full P0 PASS until every required gate passes.
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
