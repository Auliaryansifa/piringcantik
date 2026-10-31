# Deploy Piring Cantik to PHP + MySQL hosting

GitHub Pages cannot run this PHP application. Use a host that supports PHP 8+ and MySQL/MariaDB.

## Free hosting for a portfolio demo

InfinityFree offers PHP, MySQL, SSL, and a free subdomain. Create an account there, then follow the shared-hosting steps below. Its free tier is suitable for a small demo; it is not a guarantee of production-grade uptime or order delivery.

## cPanel-style hosting

1. Create a MySQL database and database user in the hosting panel, then grant that user access to the database.
2. In phpMyAdmin, select the new database. Import `database.sql`; if the host rejects `CREATE DATABASE` or `USE piring_cantik`, remove those first two SQL lines and import the remaining statements into the selected database.
3. Upload the project files into the site's document root (often `public_html`). Do not upload the `.git` folder.
4. Copy `config.local.php.example` to `config.local.php` and enter the database host, database name, database user, and password supplied by the host. This file is ignored by Git and direct web access is blocked by `.htaccess`.
5. Open the site's HTTPS URL, create a test account, and submit a test order. Remove the test data before sharing the site.

The site stores orders in the database. It does not yet process payments or send order notifications, so the owner must inspect the database to see new orders.

## GitHub Pages

GitHub Pages only serves static files and cannot run this PHP app. Keep the GitHub repository as the source, and point the portfolio link to the PHP hosting URL instead of the `github.io` URL.
