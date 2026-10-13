# Reference-led three-template design — verified main release

Tasks: P1-DESIGN-02, P1-DESIGN-03 and combined P1-04-main-release. Owner explicitly requested completion and live deployment on 13 October 2026. Status: PASS_LIVE_MAIN for the layout package, not full product readiness or owner visual signoff.

Live revision: `14a68ed92047aa0bebe657e87fe3bc32a9fd0b5b`. Successful release: https://github.com/bookorgo/BookOrGo/actions/runs/38405846968, attempt 2. Previous verified live revision: `38c14eddb86c76f909354629e1f4bd4fcd730f12`. Source application CI: `0d756a730ed1eb139641b702a1328a9552ad46ed`, run 38405559898; initial complete-layout CI 38405001461 also passed. Release changes add only the reviewed guards/verifiers and release plan to the tested application.

## Requirement and design mapping

| Surface | Completed adaptation | Verification |
| --- | --- | --- |
| UI-01 homepage | Navy/royal-blue identity, yellow search frame, six UAE area links, four fictional featured cards, six-category overlay cards, callout, three draft guide cards, inactive newsletter and footer links | 1440/768/390/320 CI; 1440/390 live; 27 JS-disabled internal targets |
| UI-02 listing | Top search, desktop filter sidebar/mobile disclosure, independent deterministic sort control, illustrated result cards, pagination/empty/error/loading states | Filter/sort/query-preservation, SSR and browser checks |
| UI-03 detail | Title above five-panel original-vector gallery, section links, six category-aware withheld fields, location placeholder, four native FAQs, disabled external-referral panel, related samples and disclosure | Six category HTTP samples; keyboard/native FAQ and gallery tests; desktop/mobile screenshot review |
| UI-04/05 editorial/shared | Existing three draft article URLs now live; information/policy placeholders with truthful draft notices, shared semantic shell and noindex | Article source/author/date/ad gates; 34 live HTTP/security/assets checks; sensitive paths denied |

Authority: Master Requirements V3.1 sections 02–04 and 10/13; Playbook V4.1 UI-01 through UI-05/P1 frontend; OWNER-20261012-MAIN and explicit 13 October completion/deployment instruction. Private documents, reference PDFs and extracted competitor imagery were not published. SVG scenes are newly authored illustrative placeholders, not factual venue media.

## Tests and evidence

- Locked PHP 8.3 dependency install, Vite/Tailwind production build, route/view/config cache and 18 feature tests / 393 assertions passed, repeated in the exact release build.
- CI Chromium: 1440/768/390/320, zero page errors/overflow; navigation, filters, sorting, pagination, loading, FAQ keyboard/native interaction and JS-disabled links/TOC passed.
- Live HTTP: 34 checks, zero failures; 25 representative content/query URLs, safe invalid-filter/404 states, five sensitive-path denials and two built assets. Exact canonical and HTML/HTTP noindex preserved.
- Live Chromium: 1440/390, homepage/listing/detail/gallery/FAQ/article/filter/menu and sorting/query preservation passed, zero page errors. Live homepage/listing/detail screenshots reviewed against CI; no blocking clipping or overflow defect.
- CI artifact 11818592057, digest `sha256:b3e34f2be3002225fa93461bcacfef4c258a8a5376f54273e0cec6fb95f0eb20`, expires 27 October 2026.
- Successful live artifact 11817079419, digest `sha256:b90d933ec9d0e5eedddfa2c51374806b990a20edfb408fbc5980b8a143176f55`; backup/activation/finalize reports and live screenshots retained in Actions evidence.

## Safe deployment outcome

Strict host checking, exact previous-revision/public-root comparison, full document-root backup and byte-for-byte restore comparison passed before activation. Source/vendor/shared environment stay outside public_html; original default.php and old release/backup retained. New release finalized VERIFIED_LIVE; incoming archive removed. No database, migration, cron, DNS, old Site/audience, ads, partner, payment or indexing change.

Backup basename: `20261013T133712Z-14a68ed92047aa0bebe657e87fe3bc32a9fd0b5b`; backup SHA-256 `fad71d9499c0a03a11405e893019eb86ebb58113e6a5bb5383edaca8b978a6e6`. Exact previous rollback remains configured. A duplicate default.php in the rollback extraction is now retained outside the web root before the empty extraction directory is removed. Rollback was not exercised during this successful activation.

Attempt 1 honestly failed before upload/activation because SSH timed out. A single supported failed-job retry succeeded with the same revision/credentials/strict host checking; no host write occurred in failed attempt 1. Failed evidence artifact 11819252155 retained.

## Limits and next work

Layout implementation is complete. Factual catalogue content and permitted photographs are not: original illustrations and fictional samples remain clearly labelled/noindex. Source fields, authors, dates, reviews, prices, inventory and partner links remain withheld. Newsletter/account/map/ads/payment features are inactive. Information/legal pages are drafts, not final approved policies. Full WCAG, Firefox/Safari, performance and owner acceptance remain P1-05; database/cron/storage/CMS remain relevant later gates. Next bounded task: P1-05 wider accessibility/performance/cross-browser checks and owner review.
