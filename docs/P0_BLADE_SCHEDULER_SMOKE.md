# P0-L04b Blade, asset and scheduler smoke proof

Date: 12 October 2026 (Asia/Karachi)  
Status: **PASS_CI_ONLY**  
Tested revision: `f652ee1ea235b6aebd2d97520e6720a6ad28127b`  
Successful run: https://github.com/bookorgo/BookOrGo/actions/runs/38222473237

## Scope

This package verifies a disposable Laravel 13 application on the known Hostinger web-PHP compatibility target (PHP 8.3). It overlays fresh BookOrGo-owned smoke templates; it does not import the deleted prototype or deploy to Hostinger.

The package includes:

- Blade SSR routes for a protected sample homepage, activity detail and blog article.
- Unique title, description, canonical URL and `noindex,nofollow` markup on every sample.
- Six planned category labels on the homepage.
- Truthful detail and editorial release-gate states with no live price, availability or partner claim.
- Tailwind/Vite production asset compilation.
- A named Laravel Scheduler no-op that writes timestamped evidence.

## Verified result

| Check | Evidence | Result |
| --- | --- | --- |
| PHP target | 8.3.35 | PASS |
| Locked packages | Laravel 13.35.0; Livewire 4.4.7; Filament 5.10.1 | PASS |
| SSR routes | 3 named GET/HEAD routes | PASS |
| Feature checks | 3 tests, 17 assertions | PASS |
| SEO safety | canonical plus `noindex,nofollow` on all samples | PASS |
| Claims safety | sample labels; no live offer or booking CTA | PASS |
| Assets | production Vite/Tailwind manifest generated | PASS |
| Scheduler | `p0-no-op` listed and executed | PASS |
| Deployment | none | NOT RUN |

Artifact 11735210224 contains the route list, test output, schedule list/run output, smoke report, scheduler proof and asset manifest. Artifact digest: `sha256:27119fbf88dc72c6b7bfc1bba099178138a8f5bb73f95a343697fe87e4cbc2c9`.

## Honest corrections

- Run 38222038879 failed because strict Composer validation promoted warnings about intentional exact evidence pins to an error. Normal Composer schema validation is now used; pins remain exact for reproducibility.
- Run 38222285085 passed dependencies, assets and all SSR tests, then failed when Laravel's default database cache expected `cache_locks`. The disposable scheduler proof now uses `CACHE_STORE=array`, which is appropriate for this isolated single-process no-op. Production cache/session design remains undecided.

## Requirements mapping

- Master Requirements V3.1 §25.3 P0-T04: protected SSR page, blog/detail SEO HTML, scheduled no-op and evidence.
- AI Execution Playbook V4.1 §2A.2/§2A.3 P0-L04: core content and metadata in first HTTP response, PHP 8.3 compatibility, built assets and scheduler proof.
- PHASE_ROADMAP P0-L04: protected Blade homepage/detail/article, scheduler and built assets.

## Limitations and next gate

This is not Hostinger scheduler, hPanel cron, storage-link, browser screenshot, database backup/restore or production deployment proof. Hostinger and existing Sites/files were untouched. P0 cannot exit until the remaining host DB, scheduler and backup/restore gates have real evidence.
