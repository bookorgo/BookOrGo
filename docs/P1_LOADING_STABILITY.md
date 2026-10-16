# P1-05e: initial filter stability and critical image loading

## Bounded change

The server-rendered listing disclosure starts closed. JavaScript expands only the desktop sidebar at initial load; it no longer collapses the mobile filter form after paint. Mobile filters remain usable natively without JavaScript, and a user opening them before JavaScript arrives is not reset. Desktop enhancement and breakpoint changes retain the prior expanded/collapsed behavior. Without JavaScript desktop users can open the native disclosure; no duplicate forms or hidden substitute controls are added.

Only the first listing card (including paginated/filter results) and main detail photo opt into the existing eager/high-priority photo component. Below-fold images remain lazy. Assets, licensed photography, crops, layout CSS, URLs, sample labels, noindex and disabled commercial controls are unchanged.

## Verification

- Feature test: initial HTML closed disclosure and exactly one eager/high-priority photo per listing/detail; lazy gallery images and noindex retained.
- Three-engine delayed-script test: hold JavaScript before first paint at 390/720/768/1440, compare results-column coordinates before/after release. Corrected displacement must be ≤1px; desktop opens, compact widths stay closed. This measures one known load transition, not all CLS.
- One-time unchanged-live reproduction must show >100px mobile displacement before deployment. Remove that old-behavior assertion from routine CI once evidence is retained.
- Native keyboard disclosure and no-JS filter form submission across Chromium/Firefox/WebKit; detail priority attributes and lazy gallery verified.
- Existing feature, five-viewport interaction and 24-state accessibility suites remain mandatory. Inspect source/live screenshots; exact design acceptance and physical-device/field CWV remain open.

## Guarded main release plan

Only after source tests and evidence pass: require exact currently verified release `74d38aae688127681208c12298aaf8e0f77dd3db` and unchanged document-root inventory. Build/test the frozen candidate; create a full public-root backup and compare extracted bytes. Retain original `default.php`, earlier release directories and recovery copies. Upload the new release outside public root, check platform dependencies, then activate. Run existing live HTTP/security/Chromium/three-engine audits plus delayed-script stability checks. Finalize only after passing; otherwise restore the exact previous release using the checked backup.

No database operation, DNS/indexing change, ads/payment/partner activation or private-document publication is included. Post-release Lighthouse comparison is separate evidence; eager loading alone does not prove an achieved LCP improvement.
