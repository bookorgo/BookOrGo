# P1-05k: bounded read-only trace capture

Requirements: Master V3.1 non-functional performance/observability goals; Playbook V4.1 QA/evidence; OWNER-20261012-MAIN. Private owner sources are not reproduced.

## Fixed experiment

Exactly six planned navigations: home, sample cruise detail, sample article; one cold then one warm visit per route. Each route starts a fresh Chromium browser/context with cleared HTTP cache. The warm visit reuses that context/cache/connections; actual cache indicators are recorded rather than assuming every response is cached. No retry loop or rerun-until-green. An access wall stops remaining navigations. No forms, clicks, deployment, database operations, DNS, ads or integration activation. Existing passive telemetry may execute as on an ordinary public navigation.

Pinned Playwright 1.56.1/its bundled Chromium, 412x823 CSS viewport, DPR1.75, mobile/touch, explicit Chrome141 Android UA, en-US. No network or CPU throttling. These observed measurements are NOT comparable to P1-05i simulated Lighthouse LCP, not field p75 or INP. One pair per route is a diagnostic sample, not a statistical performance acceptance test. Server/CDN cache state and shared-runner variance remain uncontrolled.

Trace categories retain loading, devtools timeline, user timing and top-level task events without screenshots. Record CDP request/response timing, cache flags, request failure/completion and connection reuse, but not headers/cookies/response bodies. Record buffered PerformanceObserver LCP/long tasks, Navigation/Resource Timing, visibility changes and actual LCP image currentSrc. Capture a fixed two seconds after load. Observer/trace overhead is not zero and cannot retroactively establish the prior outlier cause.

Capture gates: HTTP200, exact route, noindex, visible during the recorded interval, measured FCP/LCP, Chrome LCP trace event, document response evidence, actual detail LCP currentSrc, exact previously observed built-asset fingerprint, six unique completed slots and unchanged assets across each pair. Capture success does not mean speed or design acceptance. Failed captures and partial artifacts are retained.

Source: `.github/scripts/lcp-trace.mjs`, `lcp-trace-utils.mjs`, `lcp-trace-utils.test.mjs`; workflow `.github/workflows/lcp-trace.yml`. Seven safety/completeness tests and syntax pass locally. CI, trace outputs and findings must be verified separately and recorded in RUN_LOG/evidence. No application test or production deployment is implied.

## Privacy, retention and boundaries

Anonymous contexts only. Exported traces/rows are sanitized recursively to remove URL query/fragment/userinfo and header/cookie/body fields. No screenshots. Artifacts retained 30 days; durable derived evidence records trace SHA256s, event counts, timings, relevant network findings and limitations. Full sanitized Chrome event streams are artifact evidence, not wholesale private owner documents.

Prior verified release expected: `0d51ce8d7a29a7a235502aebedd9c02c39943a43`. Built-asset agreement is an attribution check, not a runtime revision endpoint. No release occurs here, so no live backup/rollback operation is needed. Existing Sites/files, URLs, rights, sample/noindex rules and P0 gaps remain unchanged. P6/P7 deferred; exact reference-design acceptance remains open.

## API references inspected

- https://playwright.dev/docs/api/class-browser#browser-start-tracing
- https://playwright.dev/docs/api/class-cdpsession
- https://chromedevtools.github.io/devtools-protocol/tot/Network/

## Verified result — 19 October 2026

Source `17293e50b696300a94617781cf54f7d9a5ae2e36`; [CI 39183442377](https://github.com/bookorgo/BookOrGo/actions/runs/39183442377) passed seven tests and all six capture gates. All six downloaded trace hashes and 33,858 event records verified. Durable evidence: `docs/evidence/P1-05k-lcp-traces.json`. Full sanitized trace artifact 12157495930 has independently matched SHA256 `b892b72fc2f4dccd1fd61d00f779ddf657944caa31cc3734cab2278e9d6b3597`, expires 18 November 2026.

| Page | Cold observed LCP | Warm observed LCP | Warm cache events |
|---|---:|---:|---:|
| Home | 756ms | 212ms | 11 |
| Detail | 288ms | 132ms | 10 |
| Article | 216ms | 152ms | 3 |

These unthrottled single pairs do not replace the earlier simulated Lighthouse failures. Prior heading outliers were not reproduced; no cause has been retroactively established. Cold home includes responseStart 626.9ms (server-reported cfOrigin 451ms, not independently verified) and one 58.348ms renderer task containing 48.284ms Layout. Its font completes at 810.8ms, after LCP. Detail currentSrc confirms the original Sharjah asset; cold ResourceTiming duration 41.6ms, warm cached transfer 0 bytes. All recorded documents remain visible. Warm CDP response timing can carry the cold requestTime; cache events and ResourceTiming identify reuse, not a second slow transfer.

Each warm navigation retains one Ping ERR_ABORTED; no document/CSS/image failures were observed. Action runtime/dependency deprecations are retained. No application change or deployment and no field-speed or exact-design acceptance claim.

Next P1-DESIGN-GAP-01: re-read private homepage reference, compare current 1920/390px rendering, implement one measurable geometry/typography gap with CI and guarded release if verified. Preserve accessibility, rights, original files, URLs and sample/noindex. Do not claim owner acceptance. This fixed performance investigation is checkpointed rather than repeated until green.
