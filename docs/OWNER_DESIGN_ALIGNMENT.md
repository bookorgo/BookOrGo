# Owner design alignment — 13 October 2026

Task P1-DESIGN-01. Owner reconfirmed the three homepage, listing and detail PDF references and requested immediate design correction. This takes priority over the pending article-only release.

References are private; do not upload their PDFs or extracted imagery to the public repository. Existing product/data/security requirements remain controlling.

First bounded correction: royal-blue/navy shell, yellow-framed full-width homepage search, compact discovery cards, denser filter/results layout, detail title above wide media and a right-hand referral panel. Original placeholders, sample disclosures, disabled actions, noindex, routes and server-rendered forms are preserved. No reference prices, reviews, photos, availability or third-party branding are imported.

This is an initial alignment, not completion of the three-page design. Remaining: homepage destination and featured-sample sections; a responsive multi-panel detail gallery; detail logistics/location/FAQ hierarchy; wider visual/accessibility review. Verified media and factual content remain separate release gates. No account/date/booking control should imply a working service before implementation.

Validation: git diff --check passed locally. PHP is unavailable in this scratch runtime; Laravel feature, cache, build and Chromium checks must run in repository CI. Production is unchanged pending tested guarded release and backup/rollback.
