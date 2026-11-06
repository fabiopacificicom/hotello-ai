# Feature: Guest Profiles

## Objective

Maintain guest information, preferences, and history for staff and guest self-management.

## Dependencies

[Application foundation](feature-application-foundation.md); staff and guest access depend on the approved [authentication and authorization](feature-authentication-authorization.md) policy. The minimum guest record supports [availability and guest booking](feature-availability-guest-booking.md).

## Stack

Laravel, Livewire, SQLite locally and PostgreSQL in production; Pest and Playwright.

## Implementation plan and affected files

- Define the minimum guest identity and contact fields needed for real bookings; distinguish guest records from optional user accounts.
- Implement approved guest migrations/model and connect reservations to guests. Add staff guest views and guest self-service preferences/history after access and scope decisions.
- Expected changes: guest migration/model, booking relationship, validated requests or Livewire components, protected views/policies, and `tests/`.

## Expected output

- Milestone 2 can associate a real booking with the appropriate guest without assuming guest registration is mandatory.
- Once self-service is specified, guests can access only their own approved profile, preferences, and booking history; staff access follows the approved role policy.
- Pest and Playwright cover required data, validation, associations, and access boundaries for each implemented slice.

## Decisions and constraints

Guest authentication, profile fields, identity matching, privacy and retention, and staff permissions are unresolved. Do not collect or expose data beyond the approved requirements.

## Execution checklist

1. Approve the minimum fields, duplicate/identity rules, access policy, and whether a guest must have an account; document how staff-created and guest-created bookings link to guest records.
2. Add the approved `guests` migration, model, and factory; link bookings with foreign keys and test creation and retrieval.
3. Add authorized manager listing and guest-detail flows; add guest self-service only after account ownership is defined.
4. Validate allowed fields server-side, protect queries by actor, and specify what happens to historical bookings when profile data changes.
5. Test guest association, history, validation, unauthorized access, and any approved retention or deletion rules in Pest and Playwright.

Candidate files: `application/database/migrations/*_create_guests_table.php`, `application/app/Models/Guest.php`, guest policies and views, and `application/tests/Feature/GuestProfileTest.php`; add the booking relationship in the approved booking migration/model.

## Status

[ ] Not started
