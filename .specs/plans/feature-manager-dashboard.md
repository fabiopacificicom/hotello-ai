# Feature: Manager Dashboard

## Objective

Provide the manager interface and overview from the prototype, progressing from mocked content to live operational data.

## Dependencies

[Application foundation](feature-application-foundation.md), [authentication and authorization](feature-authentication-authorization.md), and [language and navigation](feature-language-navigation.md). Live widgets additionally depend on the relevant domain features.

## Stack

Laravel, Livewire, plain CSS and Tailwind CSS; Pest and Playwright.

## Implementation plan and affected files

- Implement the protected manager route and prototype layout, responsive navigation, metric cards, calendar, enquiries, bookings, payments, assistant, and quick-action areas.
- Milestone 1 uses mocked panel data and interactions; do not imply that mock actions have saved data or contacted external services.
- In milestone 2, replace booking and booked-room views with persisted data from [reservation and calendar management](feature-reservation-calendar-management.md); other widgets become live only as their features are implemented.
- Expected changes: protected routes, dashboard views and Livewire components, mock fixtures, styles, translations, and Pest/Playwright tests.

## Expected output

- An authenticated manager can view the prototype-style panel at desktop and mobile widths; an unauthenticated visitor cannot access it.
- Booking information reflects real persisted reservations in milestone 2; still-mocked functions remain distinguishable.
- Pest and Playwright test access, rendered dashboard areas, mock behavior, and the milestone 2 booking integration.

## Decisions and constraints

Define how mock controls communicate their state. The production role and access policy is unresolved.

## Execution checklist

1. Render the manager mockup from `application/resources/views/dashboard.blade.php` on Breeze's authenticated `/dashboard` route; retain its layout, responsiveness, and sample data.
2. Include static assets only from application-controlled paths, preserving the original prototype. Add an accessible logout form using Breeze's named logout route and CSRF protection.
3. Label the dashboard as a demonstration and prevent prototype controls from claiming that real payments, messages, reports, or bookings were saved.
4. Add Pest route/authentication tests and Playwright tests for login, protected access, manager page rendering, logout, language and mobile navigation.
5. For milestone 2, replace only booking and availability fixtures with the shared booking service; keep other operations mocked until their specs are implemented.

## Verification

- Registered users see the manager mockup; guests cannot retrieve the dashboard response. Logout redirects away and subsequent dashboard requests require login.
- No manager action persists hotel domain data in the initial build.

## Status

[ ] In progress

Completed on: 2026-11-06 (prototype integration only).
Notes: The authenticated dashboard displays sample data and simulated interactions; live booking data and production access rules remain outstanding.
