# P1-05d: repeatable lab performance baseline

This package measures the existing public BookOrGo application with read-only navigation. It does not deploy, alter indexing or submit forms. Source: `.github/workflows/performance-baseline.yml` and `.github/scripts/performance-*.mjs`.

## Method

- Four templates: `/`, `/search`, `/cruises/dubai/sample-creek-cruise`, `/blog/sample-first-visit-planning`.
- Three sequential repetitions of each mobile/desktop profile: 24 navigation audits. Each uses a new browser profile and Lighthouse storage reset. Server/CDN caches can still be warm.
- Lighthouse 12.8.2 and Playwright 1.56.1 Chromium. The resolved browser version, emulated user agent, benchmark and settings are stored in every report. These direct dependencies are pinned; their transitive dependency resolutions are not lockfile-frozen.
- Mobile preset: 412×823, DPR 1.75, simulated 150ms RTT, 1638.4kbps, CPU slowdown 4. Desktop preset: 1350×940, DPR 1, simulated 40ms RTT, 10240kbps, CPU slowdown 1.
- Record per-run score, LCP, FCP, TBT, CLS, Speed Index, transfer bytes, warnings and diagnostics. Summary retains min/median/max rather than selecting the best run.
- Before/after GET checks require HTTP 200, noindex and unchanged built-asset URLs. These attribute the run to the observed build assets; they do not independently prove a runtime Git revision. Expected live revision comes from the verified release log.
- Three aggregation tests reject missing/nonfinite measurements, preserve outlier ranges and keep failed performance targets visible separately from successful execution.

## Acceptance and limitations

Master V3.1 nonfunctional targets and Playbook performance QA call for evidence before performance claims. Lab median LCP ≤2500ms and CLS ≤0.1 are diagnostic comparisons. Their satisfaction is not the field 75th-percentile gate. TBT is not INP; this navigation-only audit measures no field INP. Real user traffic, physical devices, shared runner variance and geographic differences remain open.

A successful workflow means all 24 audits and identity/noindex checks executed. It is deliberately not a blanket speed pass. Raw HTML/JSON reports and summary are uploaded as a 30-day Actions artifact; the durable repository evidence records measured summaries, artifact digest, run and revision. No private owner documents are copied into this repository.

Follow-up optimizations must preserve the reference layout, caption readability, sample labels, noindex and existing URLs. Compare the same routes/presets before and after. Asset optimizations still require source tests and the existing guarded backup/release/rollback process before deployment.
