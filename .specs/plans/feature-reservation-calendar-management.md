# Feature: Reservation and Calendar Management

## Objective

Manage reservations and show availability in the manager calendar using the same booking data as the guest experience.

## Dependencies

[Application foundation](feature-application-foundation.md), [authentication and authorization](feature-authentication-authorization.md), minimum [room inventory](feature-room-management.md), and minimum [guest records](feature-guest-profiles.md). The shared reservation service is used by [guest booking](feature-availability-guest-booking.md); neither UI needs to precede the other.

## Stack

Laravel, Livewire, SQLite locally and PostgreSQL in production; Pest and Playwright.

## Implementation plan and affected files

- Define booking fields, lifecycle, conflict and date-boundary rules, and manager permissions before implementing.
- Build shared reservation/availability logic and persisted booking models and migrations. Enforce consistency when guest and manager actions overlap.
- Replace the dashboard calendar and booking mock data with real room and booking data for milestone 2; add manager creation, details, modification, and cancellation according to agreed rules.
- Expected changes: booking migrations and models, domain services, protected routes/policies, manager Livewire components and views, and `tests/`.

## Expected output

- A manager can see guest-created bookings and booked rooms in the calendar or booking view for milestone 2.
- When implemented, manager booking actions update the same availability consumed by guests and reject conflicting or unauthorized changes.
- Pest tests cover status, dates, room independence, shared availability, access, and concurrent conflicts; Playwright covers manager views and permitted actions.

## Decisions and constraints

Inventory options are independent. Confirm manager booking workflow, statuses, adjacent-date rules, cancellation and authorization before implementation.

## Execution checklist

1. Approve the booking schema, statuses, lifecycle, conflict and adjacent-date rules, and staff permissions.
2. Add `bookings` migration, model, factory, and a shared reservation service, with database integrity and a reviewed concurrency strategy for SQLite and PostgreSQL.
3. Implement manager booking list/detail and calendar queries from persisted data; filter by selected period and room using the agreed status rules.
4. Add manager creation, updates, and cancellation through the same validated service as guest bookings; prevent unauthorized or conflicting operations.
5. Test both entry points, database rollback on conflicts, calendar date boundaries, cancellation effects, and access controls; verify the guest-created booking appears in manager views.

Candidate files: `application/database/migrations/*_create_bookings_table.php`, `application/app/Models/Booking.php`, shared reservation logic under `application/app/`, `application/resources/views/dashboard.blade.php`, and `application/tests/Feature/ReservationManagementTest.php`.

## Status

[ ] Not started
