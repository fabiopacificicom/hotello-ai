# Feature: Room Management

## Objective

Provide accommodation inventory, pricing, and availability information for guests and managers.

## Dependencies

[Application foundation](feature-application-foundation.md); manager access depends on [authentication and authorization](feature-authentication-authorization.md). Real availability integrates with [reservation and calendar management](feature-reservation-calendar-management.md).

## Stack

Laravel, Livewire, SQLite locally and PostgreSQL in production; Pest and Playwright.

## Implementation plan and affected files

- Agree on room attributes, prices, capacity, availability rules, and the minimum inventory needed for milestone 2.
- Implement the approved room migration/model and initial data for the accommodation options; expose the same inventory to guest booking and manager views.
- Add management screens for room information, availability, types, and pricing when their requirements are approved.
- Expected changes: migrations, `app/Models/`, seeders or other agreed initial-data mechanism, domain services, Livewire components, views, and `tests/`.

## Expected output

- The three prototype options can be selected for real booking and have independent availability.
- Changes to one option do not block another. Tests cover inventory selection, pricing, availability, validation, and manager authorization on the implemented slice.

## Decisions and constraints

The ADR's room schema is conceptual. Capacity, price rules, availability overrides, and permitted management actions require decisions; avoid treating prototype prices as permanent business rules.

## Execution checklist

1. Approve room identifiers, names, capacity, price precision, currency, active state, and rules for date-specific availability.
2. Add the approved room migration, model, factory, and seed data under `application/database/` and `application/app/Models/`; confirm the three named options are separate inventory units.
3. Implement an inventory query/service consumed by both guest booking and manager calendar; validate configured capacity and active state.
4. Add authenticated management screens and policies after permissions are agreed; changes to pricing must not silently rewrite past booking totals.
5. Add Pest cases for validation, active/inactive options, independent inventory, price changes, and authorized access; add Playwright coverage for selected guest and staff flows.

Candidate files: `application/database/migrations/*_create_rooms_table.php`, `application/app/Models/Room.php`, `application/database/factories/RoomFactory.php`, inventory queries under `application/app/`, manager views under `application/resources/views/`, and `application/tests/Feature/RoomManagementTest.php`.

## Status

[ ] Not started
