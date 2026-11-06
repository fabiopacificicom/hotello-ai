# Feature: Deployment

## Objective

Make milestone 1 available through a tunnel and deploy the real-booking milestone to production.

## Dependencies

[Application foundation](feature-application-foundation.md), [guest landing page](feature-guest-landing-page.md), [authentication and authorization](feature-authentication-authorization.md), and [manager dashboard](feature-manager-dashboard.md). Production also depends on the real-booking slice, production authorization policy, and approved hosting/domain choices.

## Stack

Laravel, SQLite locally, PostgreSQL in production; deployment provider and tunnel tooling are not yet selected.

## Implementation plan and affected files

- Document how to start the milestone 1 application and expose it using an approved tunnel, and how to stop the tunnel after the demonstration.
- Document that public registration intentionally grants access to the mocked manager panel for the demonstration; use only approved demo data and assess exposure before opening the tunnel.
- Decide on hosting, domain, secrets, database provisioning, backups, deployment and rollback procedures, and production authorization before the milestone 2 release.
- Configure and document approved production build, migrations, runtime and health verification. Do not deploy or create external resources without approval.
- Expected changes: application deployment documentation, environment examples, and provider-specific configuration only once selected; do not commit secrets.

## Expected output

- Milestone 1: the landing page and manager registration/login work through the approved tunnel and the tunnel can be stopped.
- Milestone 2: the deployed application uses PostgreSQL, supports real bookings, and shows booked rooms to authorized managers.
- Validate the deployed guest and manager journeys, access policy, migration, and recovery/rollback procedures against the selected environment.

## Decisions and constraints

Tunnel provider, hosting, domain, production authorization, backup, monitoring, and operating procedures are undecided. Laravel Cloud is a possibility, not a decision.

## Execution checklist

1. Document local startup and verify guest and manager routes before exposing anything. Do not start a tunnel as part of scaffolding.
2. Obtain approval for a tunnel provider and exposure; demonstrate the intentionally open registration risk with non-sensitive sample data, then stop the tunnel.
3. Before production, approve hosting/domain, restricted manager authorization, secrets, PostgreSQL, backup/restore and rollback.
4. Build assets, apply reviewed migrations, verify health and booking journeys in the selected environment; document recovery and operational ownership.

Current files: `application/README.md` and `application/.env.example`. Production configuration files and deployment scripts depend on the selected provider.

## Status

[ ] Not started
