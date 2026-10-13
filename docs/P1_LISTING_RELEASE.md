# P1-02 — Guarded main release

Date: 13 October 2026. Status: **PASS_LIVE_MAIN**.

The CI-verified P1-02 listing package is live at [bookorgo.com](https://bookorgo.com) under exact release revision `953665b8db816d7580d025e67fe7d39771078ed8`. The workflow upgraded from verified P1-01 revision `6e091e2502f0547c0d5213da1ae2b11a25915dc8`; it did not reuse the obsolete first-release assumption.

[Successful guarded production run](https://github.com/bookorgo/BookOrGo/actions/runs/38360967725).

- Preflight required the exact previous current-release marker, verified release marker and public file baseline. It passed before the upload/activation steps.
- Composer locked install, Vite/Tailwind build, route/view/config caches and 8 feature tests / 159 assertions passed.
- The 13,045,822-byte release archive passed its allowlist and SHA-256 check (`51bde51005488d3ab5f0b85c9927aed4852d156612c7b63eb7ba200fecea0308`).
- A full current document-root backup was created outside the web root and extracted to a separate restore-check directory; the byte/content comparison passed before activation. Backup SHA-256: `0d370d27d9f0fc3ad1d87ec112d706b15a6ea4c20018d12f9a8ae4fd70e8952f`.
- Host PHP 8.4.26 platform requirements, Laravel configuration/routes/Blade caches and the shared production environment file controls passed. The original `default.php` remained preserved. Database touched: no.
- Twenty bounded live HTTP/security checks passed: homepage, six categories, search, one filtered state, pagination, blog, safe invalid-filter 422, safe unknown-route 404, five sensitive paths and two built assets. Every intended HTML page retained one H1, correct canonical and meta plus HTTP `noindex, nofollow`.
- Chromium at 1440 px and 390 px passed homepage/listing rendering, filter controls, mobile menu, filtered navigation, pagination and horizontal-overflow checks with zero page errors. Live screenshots were visually reviewed with no blocking defect.
- Finalization wrote the verified-live marker and removed the incoming archive. The rollback step was skipped because all checks passed; the previous-release backup and rollback reference remain recorded.

Artifact `11794463207`, digest `sha256:41946381506d85f1b7c805c67d5fbf073ad230395a856903d89cc51f2ffa2d38`, expires 12 November 2026.

Safety and limitations: all 18 cards remain clearly fictional demonstration data. No real offers, prices, ratings, availability, booking, partner links, database, DNS, Site audience, robots/indexability, ads or payments changed. P1 is not complete. Safari/Firefox, full WCAG/performance review, real data/CMS and owner visual acceptance remain. Next task: P1-03 category-aware detail templates.
