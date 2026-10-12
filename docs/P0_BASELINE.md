# P0-L01a existing-state baseline

Observed 12 October 2026 at 01:06 UTC (06:06 Asia/Karachi).
Tested revision: aa64f9b55a60ee1fc7502f0a8014606dfcf792c3
Evidence: https://github.com/bookorgo/BookOrGo/actions/runs/38190560434
Machine-readable details: evidence/P0-L01a-baseline.json

## Findings
- Public homepage https://bookorgo.com/ returns HTTP 200, title "Default page", one H1, no canonical, no robots meta and no X-Robots-Tag. No clean category/detail/blog links were discovered in server HTML.
- /robots.txt returns HTTP 200 text/plain, with no non-comment directives. /sitemap.xml returns HTTP 404.
- The observed homepage has no detected noindex signal. This is a release concern, not proof Google has indexed it. No robots, canonical, DNS or indexing settings were changed.
- Hostinger BookOrGo public_html contains one top-level file: the marker default.php exists. No top-level subdirectories/symlinks; index.php/index.html/artisan/composer.json/wp-config.php markers are absent.
- These observations are consistent with a hosting default page. They differ from earlier historical ChatGPT Site observations. DNS change cause/timing and alternate Site availability were not verified.
- The new GitHub repository contained only workflow/checkpoint files before this package, with no Laravel application or old prototype source.

## Requirements and acceptance
| Requirement | Result | Evidence/limit |
|---|---|---|
| Playbook P0-02 / P0-L01; Master P0-T01: inspect existing state | PASS for bounded subtask | Repo tree, host metadata, homepage and crawl-control HTTP observations |
| Latest owner: preserve all existing files/Sites | PASS for this package | SSH read-only PHP metadata; public GET requests only; no deploy/delete |
| Stable URL / SEO baseline | PARTIAL | Homepage plus robots/sitemap only; no discovered category links; prior Site URL manifest still needed before cutover |
| Fresh application, no prototype reuse | PASS for this package | No old file contents imported or executed |
| P0 full feasibility gate | NOT VERIFIED | Database, web PHP, dependencies, scheduler and restore proof remain pending |

## Tests and limitations
Python syntax check passed locally. Actions job and both steps succeeded. Repeated homepage response hash matched across both captures. HTTPS certificate validation was enabled on requests; this is not a full certificate/origin audit.
The bounded auditor does not follow external/affiliate links, limits each response to 2 MB, caps discovered content routes at 18, rejects redirects outside the exact HTTPS origin, and performs no mutations.
No browser screenshots or mobile/rendering checks were performed. No existing application source, hidden configuration contents, customer records or credentials were read.
Public web-search fetch was unavailable; actual HTTP evidence comes from the successful Actions runner.
No deployment. Existing files and Site preserved.

## Next
P0-L03: clean Laravel 13 / Livewire 4 / compatible minimal Filament dependency resolution and smoke-test package in CI, with exact lockfiles.
P0-L01b: inspect design/asset references and prior URL manifest without reusing the old implementation.
Resolve default-page/canonical/indexing posture only in a reviewed release plan; do not change live SEO or DNS as part of preparation.
