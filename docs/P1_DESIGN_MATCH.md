# P1-DESIGN-MATCH: owner-requested visual correction

The owner rejected the previous visual match on 13 October 2026. A deployment/test pass is not design acceptance.

## Reference comparison
The supplied screenshots are 1920 px wide. The homepage uses an approximately 1152 px content column, compact navy header, blue hero, circular portrait, yellow segmented search overlapping the hero edge, six destination tiles, four featured cards and six category tiles. Listing/detail use an approximately 1076 px column, dense result rows and a seven-panel gallery. The correction implements these measurements in fresh Blade/CSS.

## Scope and known differences
- BookOrGo branding and UAE-only samples retained. No copied Booking.com mark or old prototype source.
- Original illustrations remain in place of photographs. Photo rights and exact font provenance remain unverified, so this is not claimed to be pixel-identical.
- Dates/travellers visually occupy reference search slots but are disabled, unnamed inputs and cannot submit invented availability. Only catalogue keyword search is active.
- Header utility buttons link to real information/journal pages, not fake accounts. Price/review/availability areas remain honest inactive states.
- Additional global destinations, actual ticket calendar, purchase flow and fabricated review panels are not enabled. Existing journal module remains.
- All existing routes, noindex signals, sample labels, source and old releases are preserved. No database, DNS, ads, payments or partner activation.

## Verification
Initial source f5da73bdfc8ddb7b1c432c42e16294744cdba98e: 18 feature tests / 393 assertions passed. Browser run 38435156144 failed at 768 px homepage overflow after 1920/1440 flows passed. Desktop screenshot review additionally found listing search behind the header. Both corrected in b83e827831a7dbdadcac5af644d0f3cc88add116; final CI pending.

## Main release/rollback plan
After successful corrected CI and visual review, use the existing guarded release workflow, frozen to the release commit. EXPECTED_PREVIOUS_REVISION must be 14a68ed92047aa0bebe657e87fe3bc32a9fd0b5b. Require strict SSH host verification, exact current-release/public-file checks, full document-root archive plus extracted restore comparison before activation. Deploy into a fresh private release directory, keep existing default.php and prior release. Run live 34 HTTP/security/asset checks and desktop/mobile browser flows with corrected headline/gallery expectations. Finalize only after all checks succeed; existing bounded rollback restores the previous baseline on failure. No database operation is part of this release.

Corrected CI 38435614659 passed at b83e827831a7dbdadcac5af644d0f3cc88add116: 18 feature tests / 393 assertions; Chromium at 1920/1440/768/390/320; search, filters, sorting, pagination, keyboard FAQ, disabled date/traveller slots, 27 no-JS internal links; zero page errors and overflow. Desktop, tablet and mobile screenshots visually reviewed. Artifact 11833555510, SHA-256 8b97acc21604ab4bfade0624c001a3e1325801811e94ff58a7338f282e63682e.

Deployment: prepared using the plan above; pending live checks. Owner visual acceptance remains open regardless of test outcome.

## P1-DESIGN-MATCH — verified live correction, 13 October 2026
Release `001b5ed75c77f26f2267bfbb001931bb3b37df31` is verified live at https://bookorgo.com; guarded run https://github.com/bookorgo/BookOrGo/actions/runs/38436156850 succeeded. Tested source b83e827831a7dbdadcac5af644d0f3cc88add116; CI run 38435614659. 18 tests / 393 assertions, Chromium 1920/1440/768/390/320, no-JS 27 links, filters/sort/pagination/FAQ passed. Live: 34 HTTP/security/asset checks, zero failures; 1440/390 browser flows, no page errors or horizontal overflow. Screenshots reviewed. Backup/extracted restore comparison passed; original default.php and previous release retained; no database operation. Rollback was available but not needed.
The initial corrected build f5da73b failed tablet overflow; screenshot review found search/header stacking. Both were fixed before deployment. Prior design acceptance was explicitly rejected by the owner; this release is a layout correction, NOT an exact/pixel-identical design acceptance. Photographs, verified font assets, live offer/review content and owner acceptance remain open. Samples/noindex and disabled dates/travellers remain. Next: P1-05 accessibility/cross-browser QA and remaining reference differences; obtain rights-verified imagery/font assets before claiming full visual equivalence. Independent authorized tasks remain, so the schedule is not paused.
