# BookOrGo application — P1-01

Fresh Laravel 13 / Blade / Tailwind application. This is the actual application source, not a staging site. Livewire 4 and Filament 5 dependencies are locked for later selective features; no public admin panel, integration or booking service is enabled.

Homepage, six category landing pages, category search and an empty travel journal render on the server without a database. All pages carry draft labels and noindex. The six directory entries are taxonomy, not sample products. Illustrations are original CSS shapes; fonts are local system fonts. No remote media, external tracking, prices, offers, approval claims or fake reviews.

## Install and check

PHP 8.3+ and Composer are required. Run `composer install`, copy `.env.example` to `.env`, generate an application key, then `npm ci` and `npm run build` using Node 22.12+ or Node 24. Configure only the intended main environment. Never commit `.env`. No migrations are needed for this slice and no install script runs migrations. Do not overwrite an existing application key.

`php artisan test`, `php artisan route:cache` and `php artisan view:cache` verify this slice. The GitHub workflow also runs browser checks/screenshots against the built app inside CI; that local test process is not a staging deployment.

## Release boundaries

GitHub main is source, not proof of Hostinger publication. The web document root must expose only `public/`; `.env`, vendor, source and logs must stay outside it. Preserve the existing document root and all prior files. A subsequent explicit release package must map the actual Hostinger root, preserve/backup existing contents, install a persistent main `.env` securely, build assets in CI, then verify live status/headers/assets with a rollback path. Do not copy the whole project into a public directory.

Database-backed catalogues, validated product templates, content administration, consent/privacy flows and booking inquiries remain later tasks. No database, scheduler, mail or production deployment is verified by these frontend checks.

## Provenance

Standard Laravel bootstrap/config files are based on `laravel/laravel` 13.x commit `f4000aeb018fcbf71d4a13e3ee4b80c7e2d45be5` (MIT). Retain the upstream license in `LICENSE`. Dependency manifests and the npm lock originated from the project's clean P0-L03 artifact (GitHub Actions run 38194341523), not the removed prototype. The Composer lock was subsequently resolved for the actual PHP 8.3.35 web runtime in run 38248683967; the original PHP 8.4 lock could not install on PHP 8.3. Framework lock: Laravel 13.35.0; Livewire 4.4.7; Filament 5.10.1; Symfony components use the compatible 7.4 series. Composer scripts that automatically migrate were removed.
