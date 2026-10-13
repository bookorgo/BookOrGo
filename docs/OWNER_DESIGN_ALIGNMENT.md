# Owner design alignment — 13 October 2026

Task P1-DESIGN-01. Owner reconfirmed the three homepage, listing and detail PDF references and requested immediate design correction. This takes priority over the pending article-only release.

References are private; do not upload their PDFs or extracted imagery to the public repository. Existing product/data/security requirements remain controlling.

First bounded correction: royal-blue/navy shell, yellow-framed full-width homepage search, compact discovery cards, denser filter/results layout, detail title above wide media and a right-hand referral panel. Original placeholders, sample disclosures, disabled actions, noindex, routes and server-rendered forms are preserved. No reference prices, reviews, photos, availability or third-party branding are imported.

This is an initial alignment, not completion of the three-page design. Remaining: homepage destination and featured-sample sections; a responsive multi-panel detail gallery; detail logistics/location/FAQ hierarchy; wider visual/accessibility review. Verified media and factual content remain separate release gates. No account/date/booking control should imply a working service before implementation.

Validation: git diff --check passed locally. PHP is unavailable in this scratch runtime; Laravel feature, cache, build and Chromium checks must run in repository CI. Production is unchanged pending tested guarded release and backup/rollback.

Verified code: `414ff50f965165f838fec0b9db1d1f08f9cb047e`; successful CI run 38402443842. Locked dependency install, Vite build, caches, 14 tests / 337 assertions and Chromium at 1440/768/390/320 passed. Additional computed-style checks confirm navy shell/yellow search frame; detail title-before-media order is verified at all four widths. Desktop homepage/listing/detail and mobile detail screenshots reviewed. No overflow/page errors in browser evidence. Initial run 38402196875 failed the mobile title/media order check; fixed without weakening the check.

Artifact 11816097228, digest sha256:6053e8e555214ae596056cf05c515a5fb26e28d9ede2ead4ab46c9912fd70ebd, expires 27 October 2026. No production deployment; existing live revision `38c14eddb86c76f909354629e1f4bd4fcd730f12` unchanged.
