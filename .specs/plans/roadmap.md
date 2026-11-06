# Product Roadmap

The [ADR](../../ADR.md) and [workflow](../../WORKFLOW.md) define the product and milestones. The initial Laravel/Breeze demo is in `../../application/`; the feature plans distinguish its completed slices from unfinished production work.

## Milestone 1: Landing page and authentication

1. [Application foundation](feature-application-foundation.md): create the Laravel application, local configuration, and test infrastructure.
2. [Language and navigation](feature-language-navigation.md), [guest landing page](feature-guest-landing-page.md), and [photo gallery](feature-photo-gallery.md): reproduce the public prototype with mocked booking and concierge behavior.
3. [Authentication and authorization](feature-authentication-authorization.md) and [manager dashboard](feature-manager-dashboard.md): manager registration and login with the prototype dashboard still mocked.
4. [Deployment](feature-deployment.md): demonstrate the application via a tunnel, including the intentionally open manager registration behavior.

Acceptance: guests can view the hotel page; managers can register and log in to see the mocked dashboard. Booking, payments, guest messaging, reports, and AI integrations remain mocked or unimplemented.

Progress: the initial local scaffold and mockup integration are in place; tunnel deployment has not been started. Livewire and later production authorization are not part of this initial build.

## Milestone 2: Real booking and production

1. Resolve the booking flow, inventory, authorization, and production hosting decisions identified in the relevant specs.
2. Implement the necessary [room management](feature-room-management.md), [guest profiles](feature-guest-profiles.md), [availability and guest booking](feature-availability-guest-booking.md), and [reservation and calendar management](feature-reservation-calendar-management.md) slices. Guest self-service profile management and full room administration need not precede the minimum booking flow.
3. Replace the relevant dashboard mock data with real booked-room information and deploy using the production steps in [deployment](feature-deployment.md).

Acceptance: a real guest booking is persisted, availability reflects it, and an authorized manager can see the booked room in the deployed application. Final production authorization and hosting must be agreed before release.

## Subsequent milestones

Schedule the remaining portions of guest profiles, room and reservation administration, and the following features after their decisions and dependencies are resolved:

- [Enquiries and messaging](feature-enquiries-messaging.md)
- [Billing and payments](feature-billing-payments.md)
- [Staff management](feature-staff-management.md)
- [Reporting and analytics](feature-reporting-analytics.md)
- [AI concierge and assistant](feature-ai-concierge-assistant.md)
- [Gallery, settings, and automation navigation](feature-gallery-settings-automation.md)

## Cross-cutting gates

- The ADR's data model is conceptual; confirm migrations and business rules before implementing them.
- Do not infer guest account requirements, payment providers, message delivery, AI permissions, production authorization, hosting, or domain from the prototypes.
- Keep independent availability for the Master Suite, Junior Suite, and Entire Villa, as decided in the ADR.
- Prototype content and interactions are reference material, not proof of working integrations. Do not edit the mockups as part of implementation.
- Use a feature branch, approved stack, Pest and Playwright; update the ADR and the relevant plan when a feature is completed.
