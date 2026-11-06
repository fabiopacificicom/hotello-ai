# Feature: Staff Management

## Objective

Support staff roles, schedules, and responsibilities.

## Dependencies

[Application foundation](feature-application-foundation.md) and an approved production [authentication and authorization](feature-authentication-authorization.md) model.

## Stack

Laravel and Livewire, SQLite locally and PostgreSQL in production; Pest and Playwright.

## Implementation plan and affected files

- Agree on roles, permissions, staff records, scheduling rules, responsibilities, and management workflows.
- Design approved staff/schedule data and authorization policies; implement protected management screens and validation.
- Expected changes: staff-related migrations/models, policies, routes, Livewire components/views, and `tests/`.

## Expected output

- Authorized managers can manage the approved staff information, roles, schedules, and responsibilities; other users cannot exceed their permissions.
- Pest and Playwright cover approved workflows, conflicts and validation, and role-based access.

## Decisions and constraints

The prototype has no detailed staff-management workflow. Data fields, scheduling conflicts, access rules, and privacy requirements must be approved before implementation.

## Execution checklist

1. Approve staff attributes, relationship to user accounts, roles, permissions, schedule states, and conflict rules.
2. Add approved migrations, models, factories and policies; ensure accounts cannot grant themselves privileged roles.
3. Implement protected staff listing, role assignment and schedule/responsibility screens with server-side validation.
4. Test authorized and unauthorized mutations, scheduling conflicts, record history, and any approved retention requirements.

Candidate files: staff and schedule migrations/models, authorization policies under `application/app/Policies/`, manager views, and `application/tests/Feature/StaffManagementTest.php`. Name entities only after the account and scheduling model is approved.

## Status

[ ] Not started
