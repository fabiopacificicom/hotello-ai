# Feature: Guest Landing Page

## Objective

Reproduce the public Villa Esmeralda landing experience from the prototype.

## Dependencies

[Application foundation](feature-application-foundation.md), [language and navigation](feature-language-navigation.md), and [photo gallery](feature-photo-gallery.md), which can be implemented alongside this feature.

## Stack

Laravel views, Livewire where appropriate, plain CSS and Tailwind CSS; Pest and Playwright.

## Implementation plan and affected files

- Implement the public route, layout, hero, accommodation and price cards, amenities, surroundings, contact details, and booking and concierge sections as shown in `prototype/mockups/landing-page.html`.
- Integrate the gallery and navigation specs; retain prototype visual styling and responsive behavior.
- Present booking and AI interactions as mocked or unimplemented in milestone 1, without claiming a real reservation, availability check, or external action.
- Expected changes: `routes/web.php`, `resources/views/`, `resources/css/`, assets under `public/` or the asset pipeline, translations, and Pest/Playwright tests. Preserve the reference mockup and verify image usage rights before copying assets.

## Expected output

- An unauthenticated guest can view the page, its listed sections and contact information, on mobile and desktop.
- Playwright checks sections, navigation, responsive behavior, gallery integration, and the displayed mock state; Pest covers the public route.
- Real bookings, payment, messaging, reporting, and AI integrations are not required for milestone 1.

## Decisions and constraints

Confirm how mocked interaction feedback is communicated and which prototype assets are cleared for reuse.

## Execution checklist

1. Add the public `/` route and create `application/resources/views/landing.blade.php` using the supplied landing mockup as the visual reference; retain sections, responsive styles, language controls, and gallery behavior.
2. Place the mockup's required static assets inside `application/public/` without editing the originals. Ensure paths work from the Laravel route and app subpaths.
3. Link to Breeze login and registration without covering or removing existing navigation. Make simulated booking and concierge interactions visibly distinguishable from live services.
4. Exercise navigation, gallery, language selection, and mobile layout in Playwright. Check public HTTP access and route behavior in Pest.
5. Compare the rendered page against the prototype at desktop and mobile widths; record any deliberate deviation.

## Verification

- The public page loads without authentication and displays the prototype's sections and existing styling.
- There is no live booking, payment, messaging, or AI backend in the initial build.

## Status

[ ] In progress

Completed on: 2026-11-06 (prototype integration only).
Notes: The application serves an adapted copy of the guest mockup with clearly mocked availability and AI. Real guest functionality remains out of scope.
