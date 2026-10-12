# P1-01 first main release plan

Status: PREPARED, NOT EXECUTED. Owner authority: OWNER-20261012-MAIN. Target is the existing main Hostinger environment; no separate staging site or temporary Hostinger database. This plan covers only the database-independent discovery shell in `site/`.

## Exact release scope

Publish `/`, `/activities`, `/holidays`, `/visas`, `/cruises`, `/yachts`, `/events`, `/search` and `/blog` with their built assets. No offers, article claims, user accounts, lead collection, partners or admin panel. Preserve existing Site, all files, DNS, robots.txt and sitemap settings. Draft noindex remains present in HTML and HTTP headers. No indexability release is included.

Known target from verified SSH/origin evidence is the BookOrGo account's `domains/bookorgo.com/public_html`. Freshly inventory before applying this plan; the earlier baseline had only `default.php`. Abort on an unexpected existing application/route conflict and reconcile the release map. Do not overwrite an unknown `.htaccess`, index file, application `.env` or shared storage.

## Build and apply

1. Acquire the repository lease and check for active host jobs. Freeze the tested source SHA; use the successful application workflow for that exact source. Composer install uses the committed PHP 8.3.35-compatible lock. CI builds Tailwind/Vite, then assembles a production dependency package excluding dev packages, tests, `.env`, node_modules and private documents. Validate platform requirements with real Hostinger web/CLI versions.
2. Connect using existing SSH secrets and strict known-host verification. Back up the current document root to an access-restricted sibling outside public_html; compare the archive listing and restored copy checksums before activation. Keep the original files in place wherever possible. Do not touch databases.
3. Install the release into a new revision-named directory outside public_html. Source, vendor, logs and environment must remain outside the web root. Prepare persistent file-backed sessions/cache and a private main `.env` with APP_DEBUG=false, HTTPS APP_URL and a generated key only if no main key already exists. Never print or upload `.env` or keys. No migration, database or cron command is required for this slice.
4. Prepare the minimum public bootstrap/routing and revisioned assets. Activate only after proving the release bootstrap works and the backup can be restored. Any necessary current-file replacement must retain its exact previous bytes and path in the rollback manifest. Never recursively delete or publish the whole project directory.
5. Verify the actual HTTPS main URL, all eight discovery routes, search, asset status/MIME, category links, noindex and canonical host. Verify `.env`, vendor, logs and source cannot be read over HTTP. Capture desktop/mobile screenshots on the main URL and compare against CI. Confirm pre-existing protected routes/files remain preserved. Record the exact source SHA, release directory and result.

## Rollback

If bootstrap, security or essential HTTP/browser checks fail, restore the previous public entry/routing files from the verified backup using the manifest. Move only newly introduced files to the retained release directory rather than deleting original contents. Restore the previous entry selection, verify the original homepage status and checksum and leave the failed revision for diagnosis outside the web root. Log the rollback; do not call a rolled-back release live. No database rollback is needed because this release performs no database writes.

## Boundaries and remaining inputs

This plan is not evidence that deployment or full production rollback has happened. The implementation job currently builds/tests only and carries no Hostinger credentials. The next bounded package is to implement and execute this guarded main release using the already verified SSH connection. Hostinger database and hPanel scheduler are later requirements for features that actually use them, not blockers for this first main homepage. Product templates, full catalogue search/filtering and verified editorial/policy pages remain subsequent P1/P2 work.
