# IT Portal

This repository includes a Laravel 12 application using the Livewire authentication starter kit. The original PHP portal and its source data remain available; the Laravel application is served from `public/`.

The public Blade interface includes a responsive home page, course catalog with code-based route-bound detail pages, faculty and staff directory, admissions information, social feeds, and a contact form that saves messages using a Form Request. Facebook and X timelines use their official embeds. Instagram does not provide an official profile-timeline embed, so the social page links directly to UCC's profile. An email button for the HOD is included in public and authenticated layouts.

## Setup

1. Install PHP 8.2+, Composer, and MySQL. Enable PHP's `pdo_mysql` extension.
2. Install PHP dependencies:

   ```powershell
   composer install
   ```

3. Create a local environment file and app key:

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```

4. Create the database in MySQL if it does not already exist:

   ```sql
   CREATE DATABASE itportal_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

   Set `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env` for your MySQL server. The defaults target a local XAMPP MySQL install.

5. To set a new known password for the seeded administrator, set `ADMIN_PASSWORD` in `.env` before seeding. If omitted, the seeder carries over the bcrypt password hash from `database/itportal.sql`.
6. Build the schema and seed the sample data:

   ```powershell
   php artisan migrate --seed
   ```

The seeders create the 10 existing courses, 5 existing staff profiles, and `admin@ucc.edu.jm`. They are safe to run again without duplicating those records.

Start the app for local development with `php artisan serve`. To use the authentication starter kit's styles, install Node.js and npm, then run `npm install` and `npm run build`. Configure Apache's document root to `public/` when using XAMPP.

## Admin

Sign in with a staff account and open `/admin` to manage courses, staff profiles, and contact messages. All `/admin` routes require authentication. Staff photos are written to Laravel's public storage disk and served through the public storage link. Create that link after installing or deploying the app:

```powershell
php artisan storage:link
```

## Progressive web app

The app uses `erag/laravel-pwa`. The PWA configuration is in `config/pwa.php`; its manifest uses the 512x512 `public/logo.png` and 192x192 `public/icons/icon-192.png`. After changing the manifest settings, regenerate `public/manifest.json`:

```powershell
php artisan erag:update-manifest
```

For local development, open the app on `http://localhost` (for example, `php artisan serve --host=localhost`) so Chrome or Edge can use the localhost secure context for service workers. The package registers `public/sw.js`, which displays the cached `public/offline.html` when a page cannot be fetched. In browser DevTools, check **Application → Manifest** and **Application → Service Workers**; test the offline fallback by enabling **Offline** in the Network panel and navigating to another page.
