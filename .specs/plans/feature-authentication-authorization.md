# Feature: Authentication and Authorization

## Objective

Enable manager registration and login and control access to manager features.

## Dependencies

[Application foundation](feature-application-foundation.md); the [manager dashboard](feature-manager-dashboard.md) consumes authenticated access.

## Stack

Laravel authentication and authorization, Livewire where appropriate, SQLite locally and PostgreSQL in production; Pest and Playwright.

## Implementation plan and affected files

- Implement registration, login, logout, session handling, and protected manager routes using approved Laravel capabilities.
- For the milestone 1 tunnel demonstration, preserve the explicitly requested behavior in which anyone who can reach the application can register and view the mocked manager panel. Make that demo behavior identifiable and prevent it from being treated as an approved production policy.
- Before production, obtain a manager registration, role, access-control, and deployment policy; apply and test it without assuming the demo policy is safe for production.
- Expected changes: user migration/model, authentication routes, controllers or Livewire components, middleware/policies, views, configuration, and `tests/`.

## Expected output

- Milestone 1: an unauthenticated visitor is denied the manager dashboard; a registered manager can log in and view it; logout ends authenticated access. Open registration remains demonstrable through the tunnel.
- Pest and Playwright cover valid and invalid registration/login, protected access, logout, and the explicitly selected registration behavior.
- Production access is not released until the production policy is approved and tested.

## Decisions and constraints

The production authorization and manager onboarding model, guest account requirements, and authentication recovery options are undecided. Do not add a dependency or assume a production authorization scheme without approval.

## Execution checklist

1. Install Breeze's Blade stack into `application/`; retain its registration, login, logout, validation, password hashing, CSRF, session, and rate-limit behavior.
2. Protect the manager route with Laravel's `auth` middleware and redirect successful registration/login to the dashboard. Expose a CSRF-protected logout control on the dashboard.
3. Keep registration open for this demo only; document the resulting access risk and explicitly block treating this design as production-ready.
4. Run Breeze's generated Pest authentication tests and add tests for the actual manager route, registration-to-dashboard flow, invalid credentials, session invalidation, and guest redirects.
5. Before production, obtain an approved access and onboarding policy, implement its authorization checks, and test both allowed and denied access.

## Verification

- A new account can register and view the manager mockup; an anonymous request is redirected to login, and logout removes dashboard access.
- The suite uses a disposable database. Production permission and onboarding checks remain a separate unresolved delivery gate.

## Status

[ ] In progress

Completed on: 2026-11-06 (demo authentication only).
Notes: Breeze provides registration, login and logout, with authenticated dashboard access. Open registration is intentionally unsafe for production; production authorization remains undecided.
