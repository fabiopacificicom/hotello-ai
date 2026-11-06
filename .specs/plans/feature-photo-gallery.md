# Feature: Photo Gallery

## Objective

Show property images with captions and an interactive lightbox.

## Dependencies

[Application foundation](feature-application-foundation.md) and [guest landing page](feature-guest-landing-page.md) for integration; no manager gallery administration is required.

## Stack

Laravel views, frontend behavior using the approved stack, plain CSS and Tailwind CSS; Playwright.

## Implementation plan and affected files

- Recreate the prototype gallery grid, image captions, lightbox open/close, and previous/next navigation.
- Add accessible image alternatives, keyboard operation and focus handling; retain the prototype styling.
- Expected changes: gallery view/component under `resources/views/`, approved image assets, styles/scripts, translation resources, and Playwright tests.

## Expected output

- Each gallery image opens with its caption, previous/next navigation changes the image, and the lightbox can be closed on desktop and mobile.
- Playwright covers open, close, both directions, and keyboard operation.

## Decisions and constraints

Confirm image licensing and final asset sources. Uploading or editing gallery content belongs to the separately scoped manager navigation feature.

## Execution checklist

1. Preserve gallery markup, image references, captions, and lightbox behavior when adapting the guest mockup.
2. Copy project-supplied local images to an application asset path; avoid modifying the mockup source or introducing a new image service.
3. Test opening images, previous/next navigation, closing, and responsive presentation. Record existing keyboard/accessibility limitations as follow-up work rather than silently claiming they are implemented.
4. Add keyboard and focus improvements when the gallery is developed beyond faithful prototype integration, with regression tests.

## Verification

- Gallery opens the selected image, navigates both directions, and closes without affecting the source prototype.

## Status

[ ] In progress

Completed on: 2026-11-06 (prototype integration only).
Notes: The initial guest page retains the prototype gallery and lightbox. Keyboard/focus improvements and final asset review remain outstanding.
