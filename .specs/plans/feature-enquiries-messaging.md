# Feature: Enquiries and Messaging

## Objective

Support guest enquiries, staff replies, and messages to guests.

## Dependencies

[Application foundation](feature-application-foundation.md), [guest profiles](feature-guest-profiles.md), and approved [authentication and authorization](feature-authentication-authorization.md). Integrates with the [manager dashboard](feature-manager-dashboard.md).

## Stack

Laravel and Livewire, SQLite locally and PostgreSQL in production; Pest and Playwright. Delivery integrations are undecided.

## Implementation plan and affected files

- Define enquiry intake, guest identification, message channels, read states, delivery and failure behavior, retention, and staff access.
- Implement approved enquiry/message migrations and models, protected staff list and reply flows, and guest contact flow if agreed.
- Connect an approved message delivery mechanism; surface delivery failure rather than displaying a simulated success.
- Expected changes: migrations/models, message service and configuration, Livewire components/views, routes/policies, and `tests/`.

## Expected output

- Staff can see enquiries, distinguish unread items, open and reply to them, and compose guest messages using approved channels.
- Tests cover persistence, read status, access boundaries, validation, and delivery success/failure without sending real messages during automated tests.
- Milestone 1 messaging remains mocked or unimplemented.

## Decisions and constraints

Providers, transport, guest enquiry entry point, sender identity, privacy, and message delivery semantics require approval; no external service is selected.

## Execution checklist

1. Approve intake and delivery channels, identity and access, message states, and retention; define how failures and retries appear.
2. Create approved enquiry/message migrations, models, factories and policies; store timestamps and status required by the agreed workflow.
3. Build manager list/detail, unread state, reply, and compose interfaces. Connect delivery through an approved service boundary without putting credentials in source.
4. Persist and display truthful delivery outcomes; handle validation and provider failure explicitly.
5. Test unread-to-read transitions, authorization, guest linkage, successful delivery and failure using test doubles; cover a manager reply in Playwright.

Candidate files: enquiry/message migrations, `application/app/Models/Enquiry.php`, `application/app/Models/Message.php`, authorized routes and views, delivery adapter under `application/app/`, and `application/tests/Feature/EnquiryMessagingTest.php`.

## Status

[ ] Not started
