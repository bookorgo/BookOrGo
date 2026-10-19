# P1-05j: offline LCP diagnosis

## Scope and reproducibility

Analyze the 48 existing P1-05f/P1-05i Lighthouse reports; no new production navigation, deployment or application changes. Requirements: Master V3.1 non-functional performance goals, Playbook V4.1 QA/evidence, OWNER-20261012-MAIN. Private owner documents are not copied here.

Run `node --test .github/scripts/lcp-diagnosis.test.mjs`, then `node .github/scripts/lcp-diagnosis.mjs BASELINE_REPORT_DIR CURRENT_REPORT_DIR`. Extract the original artifact ZIPs into those two directories first. The analyzer requires 24 unique route/profile/repeat slots in each collection, successful audits, valid observed measurements and matching Lighthouse/browser/settings. It records a SHA256 for each original JSON. Seven tests cover invalid inputs, incomplete collections, methodology mismatch, URL query removal, observed/simulated separation and retained regressions/long tasks.

Source archives: P1-05f run 38891777361, artifact 12041539562, SHA256 `f64c47ed128588abdfc54ac23796078d920fa415e8ebda00a35623d01c18a22c`; P1-05i run 39156968757, artifact 12146529335, SHA256 `ce4f351ceb8d295471dd7336693615cf91fc805a056c0aaf63efac952a23c08e`. Both hashes reverified 19 October 2026. Expired signed download links initially returned HTTP 403; fresh connector links succeeded. No access restriction was bypassed.

Durable evidence: `docs/evidence/P1-05j-lcp-diagnosis.json`. All 48 report rows and signed comparisons are retained. To keep the derived evidence focused, network rows retain Document, Stylesheet, Font and Sharjah image requests only, with total request count recorded. Profile methodology is deduplicated. Query strings/fragments are excluded from exported request URLs. Original archives retain the full reports but contain no full trace/devtools event streams.

## Findings, not causal proof

| Mobile detail observation | P1-05f repeats 1/2/3 | P1-05i repeats 1/2/3 |
|---|---|---|
| Observed LCP, ms | 269 / 308 / 293 | 609 / 411 / 281 |
| Observed resource-load duration, ms | 67.125 / 68.227 / 45.783 | 386.486 / 154.734 / 68.247 |
| Observed discovery delay, ms | 8.336 / 8.138 / 8.540 | 8.523 / 8.559 / 8.495 |
| Observed element-render delay, ms | 24.509 / 36.162 / 53.114 | 16.585 / 20.717 / 24.391 |

All six detail reports contain the same `sharjah-DPcNNgwU.webp` request: 66,308 resource bytes, High priority, HTTP/3. Current discovery checklists report discoverable, eager and priority-hinted loading. Two slower observed samples have longer resource-load durations, not materially later discovery. This does not identify origin/CDN/cache/congestion as the cause, and request presence alone does not establish element currentSrc. The third observed LCP improves while its simulated Lighthouse LCP regresses; those timing series cannot be interchanged.

Current home repeat 1 and article repeat 1 identify H1 nodes with observed render delays of 1,173.664ms and 1,160.676ms. Article first paint is 942ms after its load event and has no font requests. Home repeat 2 paints at 363ms before its font request finishes at 867.665ms. Therefore a webfont-only explanation is not supported. Source uses font-display: swap; the Inter font resource is 352,240 bytes and merits a separate byte-budget investigation, not an asserted fix for this delay. Zero simulated TBT is not proof of zero long tasks: home repeat 1 retains a 134ms long task.

P1-05i's three LCP observations above 2.5 seconds remain failures against that lab threshold. This analysis neither replaces them with greener results nor establishes field p75/INP. Shared-runner variance and three samples per condition limit inference. Exact visual-design acceptance is still open.

## Verification and release

Local seven unit tests and all 48 report extractions/comparisons passed. CI status and exact source revision are recorded in the final evidence/run log; a source-package commit alone is not CI success. No PHP, live browser, accessibility or application tests are newly claimed here. This task does not deploy; last recorded verified live release remains `0d51ce8d7a29a7a235502aebedd9c02c39943a43`, not re-probed in this offline task. Existing files, database, URLs, sample labels/noindex, image rights, DNS, ads, payments and integrations are unchanged.

## Next bounded task

P1-05k: controlled read-only trace capture for home/detail/article with a fixed small navigation budget, pinned browser/profile, explicit cold/warm conditions, full trace/network timing, page visibility and actual currentSrc. Retain every result including failures; do not rerun until green. Use that evidence to decide whether a source correction is justified. Then return to outstanding reference-design gaps and owner review. P0 operational gaps, field CWV and exact design acceptance remain open; P6/P7 remain deferred.
