# Villa Esmeralda demo application

Laravel 13 and Laravel Breeze provide registration, login and logout. The public page and authenticated manager dashboard are adapted copies of the reference mockups. The original mockups remain in `..\prototype\mockups`.

**Demo only:** Anyone who can reach the application can register and access the manager panel. Do not deploy this configuration to production or expose sensitive data. Booking, availability, payments, messaging, reporting and AI integrations are not real; dashboard values are examples.

## Local setup

From this directory in PowerShell, with PHP 8.4.1 or later, Composer, Node.js and npm installed. The locked development test dependencies require PHP 8.4.1 or later:

```powershell
composer install
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
if (-not (Test-Path database\database.sqlite)) { New-Item database\database.sqlite -ItemType File }
php artisan key:generate
php artisan migrate
npm ci
npm run build
php artisan serve
```

Open `http://127.0.0.1:8000` for the guest page. Use **Manager Login** and register an account to see the dashboard. Stop the local server with Ctrl+C.

The SQLite database and `.env` are local and ignored by Git. Never publish credentials or application keys. Mail uses the local log driver; no mail service is configured.
Generate an application key only for a new installation; changing an existing key invalidates encrypted application data and sessions.

## Tests

```powershell
php artisan test
npx playwright install chromium
npm run test:e2e
```

The browser-test runner creates and removes an isolated temporary SQLite database and starts a temporary local server on port 8123. It does not use or reset the application's local database. The original prototype tests remain separate.
