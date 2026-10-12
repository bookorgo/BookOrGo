# P0 Hostinger web-runtime and origin proof

Task: P0-L02b  
Verified: 12 October 2026 04:12 UTC  
Status: PASS for the bounded web-runtime, origin, HTTPS and small-upload checks. P0 remains incomplete.

## Purpose and safety boundary

This package verifies the real public web SAPI and its relationship to the known Hostinger document root without replacing or reading existing production content.

The workflow created a unique 128-bit random directory directly below the existing BookOrGo document root, installed one POST-only PHP probe, requested it once over HTTPS with a 1 KiB multipart upload, and removed the probe before proceeding. The response carried X-Robots-Tag: noindex, nofollow, noarchive and Cache-Control: no-store. A final SSH assertion confirmed that the transient directory no longer existed.

No existing file was overwritten or deleted. No DNS, Site, audience, robots, canonical, sitemap, database or application setting changed.

## Verified results

| Check | Result |
| --- | --- |
| Public origin | https://bookorgo.com/ returned HTTP 200 |
| HTTP policy | http://bookorgo.com/ returned 301 to the HTTPS origin |
| TLS | Hostname/CA verification passed; certificate was valid for more than seven days and reported expiry 31 December 2026 07:02:07 GMT |
| Origin/document root | The random file written under the known Hostinger public_html was served at the same public origin; web DOCUMENT_ROOT matched its verified parent |
| Web runtime | PHP 8.3.35, litespeed SAPI |
| CLI runtime | PHP 8.4.26, cli SAPI |
| Required web extensions | All probed Laravel requirements present; missing list empty |
| Web memory | 512M |
| Web execution/input limits | max_execution_time=300, max_input_time=240, max_input_vars=5000 |
| Web upload configuration | upload_max_filesize=256M, post_max_size=256M, max_file_uploads=20 |
| Actual upload | 1 KiB multipart upload accepted with error code 0 and verified by is_uploaded_file() |
| Storage visibility | Document root writable; filesystem free space was greater than zero |
| Cleanup | Transient probe directory verified absent after the request |

## Compatibility interpretation

Laravel 13's already-proven dependency set can run on PHP 8.3+, so the observed web PHP 8.3.35 clears the minimum runtime family checked by this package. However, web PHP and CLI PHP are not identical. Composer, Artisan and deployed code must therefore avoid relying on PHP 8.4-only behavior unless the web runtime is deliberately aligned through a reviewed Hostinger configuration change.

The clean-stack CI proof remains authoritative for the resolved dependency versions; this package does not deploy that scaffold.

## Honest limitations

- The displayed filesystem total/free figures describe the mounted filesystem, not the BookOrGo account quota. hPanel quota and inode limits were not exposed by this check.
- The 256M upload/post values are configuration observations; only a 1 KiB upload was actually transferred. No large-upload or timeout stress test was run.
- HSTS, supported cipher inventory and certificate auto-renewal were not tested.
- MySQL authentication/version/CRUD, scheduler execution, media storage link behavior, backup and restore remain unverified and are assigned to P0-L04a/P0-L04b.
- The initial run failed because it compared web DOCUMENT_ROOT with a CLI-only HOME value. The comparison was corrected to the probe's verified parent; the failed run remains linked below.

## Evidence

- Successful final run: https://github.com/bookorgo/BookOrGo/actions/runs/38202823303
- Successful correction run: https://github.com/bookorgo/BookOrGo/actions/runs/38202757487
- Retained failed run: https://github.com/bookorgo/BookOrGo/actions/runs/38202643328
- Machine-readable record: docs/evidence/P0-L02b-web-runtime.json

## Requirements checked

- Master Requirements V3.1 section 25.3 P0-T02: web/CLI runtime, document root, SSL, storage and resource constraints.
- AI Execution Playbook V4.1 sections 2A.2 and 2A.3 P0-L02: actual Hostinger environment proof without production replacement.
- Kickoff: protected smoke test, preserved files and no live deployment/cutover.

Next: P0-L04a with a newly isolated database and temporary migration/CRUD proof. Unknown or existing production databases must not be reused.
