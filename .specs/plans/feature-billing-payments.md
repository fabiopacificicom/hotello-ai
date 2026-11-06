# Feature: Billing and Payments

## Objective

Support booking-related payments, invoices, receipts, and reminders.

## Dependencies

[Reservation and calendar management](feature-reservation-calendar-management.md), [guest profiles](feature-guest-profiles.md), and approved [authentication and authorization](feature-authentication-authorization.md). Receipt and reminder delivery depends on the agreed [messaging](feature-enquiries-messaging.md) mechanism.

## Stack

Laravel and Livewire, SQLite locally and PostgreSQL in production; Pest and Playwright. Payment integration is undecided.

## Implementation plan and affected files

- Define supported methods, amounts, currency handling, payment states, invoice/receipt requirements, refunds, reminders, provider and access permissions.
- Implement approved payment and invoice data, manager overview, payment recording and reconciled status; connect external processing only after provider approval.
- Implement receipt and reminder flows with explicit outcomes and delivery failures, and connect appropriate financial data to reporting.
- Expected changes: migrations/models, payment domain service and configuration, provider integration if approved, protected Livewire views, and `tests/`.

## Expected output

- Authorized staff can inspect payment status and record payments against bookings; invoices, receipts, and reminders behave according to approved rules.
- Tests cover amount validation, status transitions, authorization, duplicate handling, and provider/delivery success and failure.
- No real payment integration is required in milestone 1; never infer that the prototype's card/SEPA display is a working integration.

## Decisions and constraints

Providers, financial compliance, storage of sensitive payment information, methods, partial payments, refunds, and invoice rules are unresolved. Do not store card details or select a provider without an approved design.

## Execution checklist

1. Agree on provider, supported methods, amounts/currency, invoice and receipt fields, refund rules, reminder delivery, and staff permissions.
2. Create approved payment/invoice migrations and models linked to bookings; use a money representation agreed for SQLite and PostgreSQL.
3. Implement validation, recording, status transitions, and provider callbacks only for the approved integration; make repeat notifications safe.
4. Build protected payment list and detail screens, receipt and reminder flows, and explicit error/reconciliation handling.
5. Test partial/invalid amounts, duplicate callbacks, payment states, unauthorized access, provider failure, and receipt/reminder outcomes with test doubles.

Candidate files: payment/invoice migrations and models under `application/database/` and `application/app/Models/`, payment services and policies under `application/app/`, manager payment views, and `application/tests/Feature/PaymentTest.php`.

## Status

[ ] Not started
