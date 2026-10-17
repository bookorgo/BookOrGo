# P1-05f: post-loading-fix lab comparison

Scope: read-only measurement of the verified P1-05e release, not another application deployment. Requirements: Master V3.1 nonfunctional performance targets, Playbook V4.1 performance QA/evidence bundle and OWNER-20261012-MAIN.

Reuse P1-05d's four routes, three fresh-browser repeats and mobile/desktop presets. The comparison checks 24 measurements, unique repeat IDs, matching Lighthouse/browser/settings and no audit failures. It retains min/median/max and signed deltas for every metric, including regressions and CLS outliers. Six unit tests cover aggregation and comparison. The baseline's compact runs/profile schema is normalized without changing measurements.

The expected live revision comes from the successful guarded release log; HTTP/noindex and asset fingerprints before/after detect observed build changes. They do not independently attest a runtime Git revision. No application files, database, DNS, indexing, commercial controls, existing URLs or assets are changed by this package.

These are independent small lab samples on shared CI, not a controlled causal experiment. Server/CDN warmth, geographic/network variation and hardware noise can affect deltas even with the same browser/settings. Lighthouse and Playwright direct versions are pinned, but transitive dependency resolutions are not lockfile-frozen. No field p75, INP, physical-device or exact owner-design acceptance is implied. TBT is not INP.

Results and evidence are recorded in `evidence/P1-05f-performance-comparison.json` after the run completes. Responsive-image work is a separate bounded follow-up: preserve original licensed files, provenance, visible credits, crop/geometry, noindex and labels; add derivatives without importing reference media or making new rights claims. Require source tests, rendered-image/crop checks and a guarded release/rollback before live replacement.
