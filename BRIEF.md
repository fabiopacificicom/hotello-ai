# Hotel Management System

This document provides a brief overview of the Hotel Management System, outlining its purpose, key features, and intended users.

The application will be built from the guest landing page and manager dashboard prototypes. The prototypes illustrate the intended experience; their simulated actions and data are not evidence of working booking, payment, messaging, reporting, or AI integrations.

## Stack

- **Full stack:** Laravel (latest).
- **Frontend reactivity:** Livewire.
- **Styling:** Plain CSS and Tailwind CSS; retain the prototypes' current styling for the first milestone.
- **Database:** SQLite locally and PostgreSQL in production.
- **Testing:** Pest and Playwright for end-to-end testing.

## Components

- **Authentication and Authorization:** Allows managers to register and log in to access the manager dashboard.
- **Hotel Manager - Reservation Management:** Handles room bookings, cancellations, and modifications.
- **Guest Management:** Maintains guest profiles, preferences, and history. (todo - mockup not available yet)
- **Hotel Manager - Room Management:** Manages room availability, types, and pricing.
- **Hotel Manager - Billing and Payments:** Processes invoices, payments, and generates financial reports.
- **Hotel Manager - Staff Management:** Manages staff roles, schedules, and responsibilities.
- **Hotel Manager - Reporting and Analytics:** Provides insights into occupancy rates, revenue, and other key metrics.
- **Hotel Manager - AI concierge:** Provides an AI agent that offers assistance and can perform tasks on the platform for hotel staff and guests. Chat is shown in the mockups; the broader task-performing agent remains to be defined.
- **Guest - Booking Management:** Allows guests to make, modify, and cancel reservations. (todo - mockup not available yet)
- **Guest - Profile Management:** Allows guests to manage their profiles, preferences, and history. (todo - mockup not available yet)

- **Guest - Property Information:** Landing page with property highlights, accommodation types, nightly prices, amenities, local attractions, and contact details.
- **Guest - Photo Gallery:** Property photos with a lightbox, captions, and previous/next navigation.
- **Guest - Availability Check:** Check-in and check-out dates, guest count, and room type selection, with date validation and availability feedback.
- **Guest - AI Concierge:** Chat for questions about restaurants, activities, check-in and check-out, house rules, and amenities. The mockup also depicts a restaurant reservation in an example conversation.
- **Hotel Manager - Dashboard:** Overview of active bookings, monthly revenue, in-house guests, new enquiries, recent bookings, and payments, with quick actions and export/report controls.
- **Hotel Manager - Calendar:** Monthly calendar with previous, next, and today controls, and selected-day availability.
- **Hotel Manager - Bookings:** New-booking form and booking details showing guest, room, dates, amount, and status.
- **Hotel Manager - Enquiries and Messaging:** View enquiries, distinguish unread messages, reply to enquiries, and compose a message to a guest.
- **Hotel Manager - Payments:** Payment overview with methods and statuses, payment recording, receipts, and reminders.
- **Hotel Manager - AI Assistant:** Chat for assistance with bookings, availability, guests, payments, revenue, and reports.
- **Hotel Manager - Navigation Placeholders:** Guest list, gallery, settings, analytics, and automation are represented in the manager navigation.
- **Both - Language and Navigation:** English and German language selection and mobile navigation.

## Delivery Scope

### Milestone 1: Landing Page and Authentication

- Decompose the product from this brief and the prototypes into an ADR covering the application flow, components, and data schema with an ER diagram. Plan the ADR features in dedicated specs and organize them into a roadmap.
- Develop the hotel front page as the main application landing page, following the guest prototype.
- Allow a manager to register and log in to view the dashboard following the manager prototype.
- Deploy the milestone through a tunnel.
- Acceptance: a guest can view the hotel page; a manager can register and log in. Booking remains mocked, as does the manager panel.

The workflow intentionally uses this milestone to demonstrate an authentication and authorization issue: anyone able to access the application through the tunnel can register and see the manager panel.

### Milestone 2: Real Bookings and Production Deployment

- Determine hosting and domain arrangements, then deploy the application to a production server and connect a new or existing domain. Laravel Cloud is a possible option, not a confirmed choice.
- Implement a real booking system and allow the manager to see booked rooms.
- Continue developing the remaining features in subsequent milestones.

## Decisions Still Needed

- The hosting and production domain.
- The detailed scope, integrations, and acceptance criteria for features beyond the milestone goals above.
- The production authorization model for manager registration and dashboard access.

## Intended Users

- **Hotel Staff:** Front desk personnel, managers, and housekeeping staff who need to manage reservations, guest information, and room availability.
- **Hotel Management:** Administrators and managers who require access to reporting, analytics, and staff management features.
- **Guests:** Individuals making reservations and managing their bookings through the system.
