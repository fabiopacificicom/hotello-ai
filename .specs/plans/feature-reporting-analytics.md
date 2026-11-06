# Feature: Reporting and Analytics

## Objective

Provide operational and financial insights, including occupancy and revenue.

## Dependencies

Approved [authentication and authorization](feature-authentication-authorization.md), [room management](feature-room-management.md), [reservation and calendar management](feature-reservation-calendar-management.md), and [billing and payments](feature-billing-payments.md) for payment-dependent figures.

## Stack

Laravel and Livewire, SQLite locally and PostgreSQL in production; Pest and Playwright.

## Implementation plan and affected files

- Define metrics, periods, occupancy and revenue calculations, report content, export format, time zones, and access.
- Implement calculations from persisted domain data, manager views, and approved report/export behavior; connect dashboard metrics to the same definitions.
- Expected changes: reporting queries/services, protected routes/policies, Livewire components/views, export code if approved, and `tests/`.

## Expected output

- Authorized users can view approved occupancy and revenue metrics and generate the agreed reports.
- Tests validate calculations against known bookings and payments, date boundaries, empty data, authorization, and export behavior.
- The milestone 1 report/export controls remain mocked or unimplemented.

## Decisions and constraints

Metric definitions, reporting periods, export formats, and whether revenue means booked or received amounts must be decided. No analytics implementation is shown by the navigation placeholder.

## Execution checklist

1. Approve metric formulas, reporting periods/time zone, filters, required output, and who can view/export each report.
2. Create query services for the approved booking, room, and payment data; define handling of cancellations, partial payments and empty periods.
3. Wire dashboard metrics and reporting screens to the same calculations; add the approved export format if required.
4. Test known datasets including overlapping periods, zero occupancy, cancelled bookings and partial payments; check permissions and export contents.

Candidate files: reporting queries under `application/app/`, protected manager views, `application/tests/Feature/ReportingTest.php`, and an export implementation only after its format is selected.

## Status

[ ] Not started
