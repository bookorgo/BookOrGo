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

Next decision: inspect all six traces, retain unreproduced results honestly, and identify a justified bounded source correction only if supported. Do not keep repeating performance investigations indefinitely; return to outstanding design-reference gaps once this fixed experiment is checkpointed.
