# Feature: Language and Navigation

## Objective

Provide English and German navigation and language selection across the guest and manager experiences.

## Dependencies

[Application foundation](feature-application-foundation.md); integrated with the [guest landing page](feature-guest-landing-page.md) and [manager dashboard](feature-manager-dashboard.md).

## Stack

Laravel localization, Livewire where appropriate, plain CSS and Tailwind CSS; Pest and Playwright.

## Implementation plan and affected files

- Establish the translation and language-selection mechanism supported by Laravel; reuse it across both surfaces.
- Reproduce prototype navigation, section links, language controls, and responsive guest menu and manager sidebar/bottom navigation.
- Expected changes: `routes/web.php`, shared layouts and navigation under `resources/views/`, translation resources, frontend styles/scripts, and `tests/`.
- Preserve meaningful links and usable keyboard, focus, and mobile interactions; select and document the language persistence behavior before implementation.

## Expected output

- Guest and manager navigation works at desktop and mobile widths; guest section links reach their targets.
- Language changes affect implemented interface text on both surfaces. Pest covers locale behavior; Playwright covers language switching and mobile navigation.

## Decisions and constraints

Agree on default language, persistence, and fallback behavior; do not assume partially translated prototype text is a required limitation.

## Execution checklist

1. Preserve each supplied mockup's DE/EN selectors and responsive navigation when moving it into the Laravel views.
2. Add working login/register links on the public page and a logout form on the authenticated manager page without changing existing navigation destinations.
3. Test both language controls, guest anchors, manager sidebar and mobile menu; use the browser's persisted language behavior already shown by the prototypes for this demo.
4. For later product localization, agree on shared persistence and fallbacks before migrating prototype strings into Laravel translation files.

## Verification

- DE and EN controls update the demonstrated content; mobile navigation opens and closes and links remain usable.
- Authentication links target Laravel routes and the existing mockup navigation remains intact.

## Status

[ ] In progress

Completed on: 2026-11-06 (prototype integration only).
Notes: The initial views retain prototype language selectors and navigation. Full translation and a shared localization policy remain outstanding.
