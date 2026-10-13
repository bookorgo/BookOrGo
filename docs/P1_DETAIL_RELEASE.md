# P1-03 — Guarded main release

Date: 13 October 2026. Status: **PASS_LIVE_MAIN**.

The CI-verified P1-03 category-aware detail package is live at [bookorgo.com](https://bookorgo.com) under exact release revision `38c14eddb86c76f909354629e1f4bd4fcd730f12`. The workflow upgraded from verified P1-02 revision `953665b8db816d7580d025e67fe7d39771078ed8`.

[Successful guarded production run](https://github.com/bookorgo/BookOrGo/actions/runs/38374158337).

- Preflight required the exact previous current-release marker, verified-live marker and public file baseline. It passed before upload or activation.
- Composer locked install, Vite/Tailwind build, route/view/config caches and 11 feature tests / 304 assertions passed.
- The 13,051,493-byte release archive passed its allowlist and SHA-256 check (`d9d734705da5e90c355b6556b10e306fb69df44ffaee6da9eb4c6ffa23b5f3da`).
- A full current document-root backup was created outside the web root and extracted to a separate restore-check directory; exact comparison passed before activation. Backup SHA-256: `6efb4775db7e386e102bd14d9e02b8bd9e3c423cfae34dc8b75e7a45a122cdb5`.
- Host PHP platform requirements and Laravel configuration/routes/Blade caches passed. The original `default.php` remained preserved. Database touched: no.
- Twenty-six live HTTP/security checks passed with zero failures: homepage, six category listings, three search/filter/pagination states, blog, six representative category detail routes, invalid-filter 422, unknown-route 404, sensitive path denial/absence and built assets. Intended HTML pages retained one H1, exact canonical and meta plus HTTP `noindex, nofollow`.
- Chromium at 1440 px and 390 px passed homepage, listing, category-aware detail, filters, filtered navigation, pagination, mobile menu and horizontal-overflow checks with zero page errors. Live desktop/mobile detail screenshots were visually reviewed with no blocking hierarchy, disclosure, disabled-state, clipping or overflow defect.
- Finalization wrote the verified-live marker and removed the incoming archive. Rollback was available but skipped because all checks passed.

Artifact `11799804034`, digest `sha256:ae1a0636a751249ecfa1a8c92e2a06fcadcbef165f392ccc44b05675517918c8`, expires 12 November 2026.

Requirements checked: Master Requirements V3.1 detail fields, detail templates, evidence/rights, accessibility, release safety and protected indexation controls; Playbook V4.1 P1-03 and release controls; OWNER-20261012-MAIN; fresh-build/no-prototype-reuse rule. Owner references influenced structure only; no third-party brand, copy, price, rating, map or media was imported.

Safety and limitations: all 18 records remain labelled fictional samples. The live detail pages expose required future field names while values remain honestly withheld, and referral actions remain disabled. No real offers, prices, schedules, availability, ratings, bookings, partner links, database, DNS, Site audience, indexability, ads or payments changed. Safari/Firefox, full WCAG/performance review, real sourced data/CMS and owner visual acceptance remain.

Next task: P1-04 reusable blog article layout and listing reuse.
