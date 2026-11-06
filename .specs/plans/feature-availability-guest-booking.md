# Feature: Availability and Guest Booking

## Objective

Allow guests to check real availability and make, modify, and cancel reservations.

## Dependencies

[Application foundation](feature-application-foundation.md), [guest landing page](feature-guest-landing-page.md), a minimum [room inventory](feature-room-management.md), a minimum [guest record](feature-guest-profiles.md), and shared reservation logic from [reservation and calendar management](feature-reservation-calendar-management.md).

## Stack

Laravel, Livewire, SQLite locally and PostgreSQL in production; Pest and Playwright.

## Implementation plan and affected files

- Keep the initial date, guest-count, and room selection mocked in milestone 1.
- Agree on booking steps, required guest details, dates, status transitions, price calculation, confirmation, and change/cancellation rules before implementing the real flow.
- Use a shared reservation service for availability and booking persistence; check availability again at booking time and prevent concurrent conflicting bookings for the same option.
- Implement modification and cancellation after their rules are approved; update the guest experience to show truthful outcomes and validation errors.
- Expected changes: guest booking routes and Livewire components, booking/guest/room migrations and models, shared domain service, views, translations, and `tests/`.

## Expected output

- Milestone 2: valid available dates and an accommodation can produce a persisted booking visible to the manager; invalid or unavailable requests cannot produce a conflicting booking.
- Independent accommodation options do not block one another. The behavior on adjacent dates, modifications, and cancellations follows approved rules.
- Pest covers date validation, conflict detection, independent inventory, persistence, changes/cancellation, and concurrent attempts; Playwright covers the real guest journey and visible errors. Verify concurrency against the production database engine as well as local behavior.

## Decisions and constraints

The date boundary convention, capacity, booking confirmation, guest account requirement, multi-accommodation booking, price rules, and cancellation policy are undecided. Do not represent a mocked success as a real booking.

## Execution checklist

1. Specify the user journey, required fields, date boundary, booking states, prices, capacity, and authorization for changes and cancellations; resolve each open decision before coding.
2. Implement server-side availability queries and form validation using the common reservation service; display availability without claiming a reservation exists.
3. Submit a reservation through a database transaction that rechecks availability and rejects competing claims atomically under the chosen production database strategy.
4. Persist the guest, selected room, dates, agreed amount, and booking status; return a clear confirmation or a validation/conflict error.
5. Add approved modification/cancellation flows; update availability and show the result to the guest and manager.
6. Test valid, missing, reversed, adjacent and conflicting dates, independent options, capacity, simultaneous submissions on PostgreSQL, state changes, and actual manager visibility.

Candidate files: `application/routes/web.php`, guest booking views or Livewire components, `application/app/Services/ReservationService.php` if a separate service is warranted, `application/tests/Feature/GuestBookingTest.php`, and `application/tests/e2e/booking.spec.js`.

## Status

[ ] Not started
