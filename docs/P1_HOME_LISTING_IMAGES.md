# P1-05h — homepage/listing responsive images

## Scope and requirements
Master V3.1 permitted media and non-functional performance; Playbook V4.1 responsive QA and mandatory evidence; OWNER-20261012-MAIN. Owner documents read privately, not published. Reuse the seven rights-registered originals and existing 26 build-time derivatives from P1-05g; no new media, dependency, CSS, crop, content, URL or indexability changes.

Home and listing photo components now emit native SSR srcset/sizes with unchanged original fallback, empty decorative alt, dimensions and loading/priority policy. Shared per-photo envelopes avoid duplicate derivative downloads when a photo appears in several differently sized frames. Cover sizes include source aspect ratio, tall inspiration cards, mobile one-column featured/category cards, and the transformed desktop hero. Conservative envelopes prefer sufficient resolution over maximal byte savings. No JavaScript image loader is introduced.

## Verification plan
PHP regression tests cover home, search pages 1/2, empty results, candidate descriptors and unchanged priority/fallback guards. Existing asset tests verify original hashes, variant dimensions/aspect/bytes and Vite emissions. Browser matrix: home/listing/detail × Chromium/Firefox/WebKit × 320/390/768/1440 × DPR1/2 = 72 no-JS cases. Check verified candidates, >=90% required cover resolution, smaller unique selected visible-image file sizes, exact original-fallback geometry/crop policy, overflow/noindex and priority. Hidden mobile hero is excluded from visible-image byte totals; these are not transfer or LCP measurements. Retain functional/accessibility and loading-stability suites.

## Release gate
Status: SOURCE_PREPARED; tests pending, not passed. Do not activate until foundation and source-quality runs pass and source screenshots are reviewed. Live remains a00c13e99f15484f6d44524996ccab3b99e3097d. Any release must expect that exact previous revision, use the existing guarded full public-root backup/extracted comparison and rollback workflow, run all live checks including 72 responsive cases, and finalize only on success. Original default.php, previous releases, backups and database remain untouched. No DNS, ads, payments, affiliate activation or public sample indexing.

## Limits / next
Exact owner reference-design acceptance, physical devices/screen readers, field CWV and relevant P0 DB/cron/storage remain open. Fresh measured Lighthouse comparison follows successful delivery; do not claim timing improvement from selected file sizes. P1 incomplete, P6/P7 deferred.
