# P1-01 guarded main release

Status: PASS_LIVE_MAIN. Verified 12 October 2026. Owner authority: OWNER-20261012-MAIN.

## Release identity

- Source revision: `6e091e2502f0547c0d5213da1ae2b11a25915dc8`
- Successful workflow: https://github.com/bookorgo/BookOrGo/actions/runs/38288802464
- Artifact: `11764123926`, digest `sha256:bdf083216d7dcecc47b10d178ee497483470aedf96a4df759f5897ace50fb0b4`, expires 11 November 2026
- Release package SHA-256: `962cbea99ddc7b770f966eb729857c3e1a1563e7c35d660347ebb1e4f46b1a4a`
- Backup: `/home/u809119518/domains/bookorgo.com/backups/20261012T180806Z-6e091e2502f0547c0d5213da1ae2b11a25915dc8`
- Backup SHA-256: `f42596fef81c466c333e0ca4e8dce1f7f849f7eedb977aac7763319ea3ad74ed`

## Verified result

The frozen Laravel 13 source passed Composer validation/install, Vite/Tailwind build, five feature tests with 65 assertions, route/view/config caching and Hostinger platform checks. Strict known-host SSH, exact one-file production baseline, package checksum and archive path safety passed before activation. The existing `default.php` was preserved. Source, vendor, storage and the private environment remain outside `public_html`; only the public bootstrap, rewrite file and built assets were activated.

Live verification checked `/`, six category routes, `/search?q=boat` and `/blog`. Every intended page returned 200, one H1, its canonical URL, the preview marker and both HTML and HTTP `noindex, nofollow`. The built CSS and JavaScript returned 200 with expected MIME types. An unknown route returned 404. Probes for `.env`, Composer source, `artisan`, vendor autoload and Laravel logs were denied or absent. Chromium checks at 1440 px and 390 px passed homepage, search, mobile menu and overflow assertions with zero page errors. The retained screenshots were visually reviewed.

## Corrections and rollback evidence

Run `38254837031` failed before host access because the feature tests were executed before the Vite build; production was untouched. Run `38255012519` passed build, backup, restore-check and HTML activation but the live verifier detected 404 responses for built assets. The workflow then moved only the revision-added public files out of the document root and restored the exact `default.php` baseline; no database was touched. Root cause was mode 700 on the copied asset directory. The successful revision explicitly sets public asset directories to 755 and files to 644 before activation. No failed attempt is represented as a successful release.

## Boundaries

This is a labelled first-look discovery shell, not a completed catalogue. It contains no real products, prices, availability, offers, approvals, booking flow, partner integration, payment, ads or published journal articles. It remains noindex. No DNS, ChatGPT Site, audience, database or scheduler change was made. P1 remains open; P1-02 listing/filter/state work is next. Host database, database restore, durable media and hPanel scheduler evidence remain unresolved until relevant features require them.
