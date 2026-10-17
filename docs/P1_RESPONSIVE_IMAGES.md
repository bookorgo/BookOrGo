# P1-05g — detail-page responsive images

Bounded source slice: ten images on the detail template use build-time WebP derivatives and server-rendered srcset/sizes. Other templates retain their existing image selection. No CSS, original asset, crop, caption, credit, label, URL or indexing setting is changed. Photos remain illustrative, not images of fictional experiences.

The build-only sharp dependency is exactly pinned in package-lock.json. The build verifies all seven originals against the existing media provenance register, resizes the full frame without upscaling, and omits re-encoded candidates that are not smaller than their original. The generated manifest and variants remain in the release package; Vite emits hashed assets. Node/image processing is not required at Hostinger runtime. Run from site/: npm ci --ignore-scripts; npm run build; npm run test:images.

Detail slot sizes account for object-fit:cover and portrait/landscape aspect ratios rather than blindly using cell width. Existing eager/high-priority main image, nine lazy images, original src fallback and empty decorative alt attributes remain. Native browser responsive selection requires no JavaScript. Missing build metadata fails instead of silently claiming optimization.

Verification: source-hash/geometry/byte and Vite-manifest tests; Laravel SSR checks; existing functional/accessibility/loading suites; three-engine 390/768/1440 at DPR1/2 with JavaScript disabled, image decode and original fallback, layout/crop-policy parity. Unique selected asset bytes are NOT actual network transfer or a new LCP measurement. Inspect generated screenshots before a release claim. Exact owner design acceptance and field CWV remain open.

No production deployment is implied by source CI. A follow-up guarded release must require exact current release 881201d5, full public-root backup/extracted-byte comparison, preserve default.php and prior releases, include the generated source manifest and Vite assets, verify live HTTP/browser/image behavior and restore the exact backup on failure. No database, DNS, indexing, ad, payment or partner change. Independent P0 operational gates and P6/P7 deferral remain unchanged.

Requirements: Master V3.1 trust/permitted media and nonfunctional performance; Playbook V4.1 responsive/performance QA and evidence; OWNER-20261012-MAIN. Implementation API references: https://sharp.pixelplumbing.com/api-resize/ and https://sharp.pixelplumbing.com/api-output/ (checked 18 October 2026 Asia/Karachi). Private owner documents are not copied into the repository.
