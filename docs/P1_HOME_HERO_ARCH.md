# P1-DESIGN-GAP-01 — homepage hero arch

## Bounded finding and correction

20 October 2026. Compared the owner-supplied homepage PDF's native 1920px raster with the homepage 1920/390px screenshots from foundation run 39113838952 (tested source 5d4c6a18, deployed in release 0d51ce8d). Artifact 12131129884 SHA256 b3a11c45123934ef825682f68a59d11afc83e4250c7f743364f1220e42cb9625 independently verified. The reference has an arch-shaped photo with a rounded crown and shallow bottom corners; the current inner photo mask is a full ellipse. The reference is private and is not copied into this repository.

Change only the homepage inner portrait clipping: four 50% corners become 50%/50%/18%/18% (clockwise from top left). The 18% lower radius is an implementation approximation based on the visible reference, not a recovered source-code value or a pixel-perfect claim. Existing outer orbit, frame dimensions/insets, rotation, image/crop/priority, label, content and responsive visibility remain unchanged. No changes to listing/detail/article layouts.

## Verification and limitations

Foundation browser regression records computed radii, clipping and dimensions at 1920/1440/768/390/320. Desktop negative control restores the prior circle temporarily and verifies it differs without moving the frame; mobile decoration must remain hidden. Existing full functional, no-JS, PHP, accessibility, stability and responsive-image tests remain required. Inspect desktop and mobile output screenshots before release. Tests pending until recorded in RUN_LOG; local syntax alone is not a browser pass.

Scope: Master V3.1 visual/responsive/accessibility requirements; Playbook V4.1 P1-01 and QA evidence; OWNER-20261012-MAIN. All private owner documents remain private. Original image rights/credits, UAE-only samples, noindex, disabled commercial controls and stable URLs preserved. Exact three-template match, owner design acceptance, physical-device/screen-reader checks, field CWV and relevant P0 database/cron/storage gates remain open. P6/P7 deferred.

## Reviewed incremental release and rollback plan

Release only after source foundation and quality runs pass and rendered screenshots are inspected. The production workflow must require exact prior verified release 0d51ce8d7a29a7a235502aebedd9c02c39943a43, unchanged public-root inventory, matching old built assets and strict SSH host verification. Build and test the frozen candidate. Create a full public-root backup and compare its extracted bytes before activation; keep existing default.php, prior releases and backup copies. Do not touch the database, DNS, robots/indexability, ads, payments, partner activation or Sites.

After activation require existing HTTP/security/browser, three-engine accessibility, stability and responsive-image gates, plus the hero-mask assertion. On failure use the existing exact-target rollback restoring backed-up index/.htaccess/build and previous-revision pointer; retain failed release evidence. A successful CI source run is not a deployment claim. Record actual revision, runs, backup digest, artifact digest and limitations in RUN_LOG before releasing the task lease.
