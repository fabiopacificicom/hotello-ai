# Feature: Application Foundation

## Objective

Establish the Laravel application and its local development and testing baseline.

## Dependencies

Approved [ADR](../../ADR.md); no application feature dependencies.

## Stack

Latest Laravel, Livewire, plain CSS and Tailwind CSS, local SQLite, Pest, and Playwright.

## Implementation plan and affected files

- Scaffold the Laravel application at the agreed repository location; confirm the target location before scaffolding if it is not established.
- Configure local SQLite and environment examples without committing credentials or a populated database. Preserve `prototype/` and its existing tests.
- Set up the frontend asset pipeline, Livewire, Pest, and a Playwright application test configuration using the approved stack.
- Expected files include `composer.json`, `package.json`, `.env.example`, `routes/web.php`, `resources/`, `tests/`, and Playwright configuration; exact paths depend on the generated scaffold.
- Document installation, local startup, migration, asset build, and test commands in the application README.

## Expected output

- A fresh checkout can be configured locally, migrated against SQLite, started, and tested using documented commands.
- A basic application route and representative Pest and Playwright smoke tests pass. No real booking or hotel data is implied.

## Decisions and constraints

Confirm the scaffold location and any version-specific installation choices before implementation. Do not install unapproved libraries or alter prototype mockups.

## Execution checklist

1. Create `application/` with Laravel 13, preserving the root prototype and repository history. Install Laravel Breeze with the Blade authentication stack and Pest support.
2. Configure `application/.env.example` for SQLite; create the local database and application key locally, never commit `.env` or the database.
3. Configure application routes and assets; install and build frontend dependencies. Keep application dependencies and locks inside `application/`.
4. Add Pest and Playwright application-level smoke tests; run the PHP suite, frontend build, and browser suite from a clean test database.
5. Document exact setup, migrations, start, build, and test commands and the intentional demo authorization limitation in `application/README.md`.

## Verification

- `composer install`, `npm ci`, database setup, migration, and build succeed on a fresh checkout with supported tooling.
- The public page returns 200; `/dashboard` requires authentication. Tests use an isolated database and do not alter user data.

## Status

[ ] In progress

Completed on: 2026-11-06 (initial scaffold only).
Notes: `application/` uses Laravel 13, Breeze Blade, SQLite, Pest, and Playwright. Livewire integration is deferred until required by a later feature; the complete foundation has not yet been delivered.
