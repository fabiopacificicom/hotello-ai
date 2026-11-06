# Feature: AI Concierge and Assistant

## Objective

Provide guest and staff assistance through chat and approved platform tasks.

## Dependencies

[Guest landing page](feature-guest-landing-page.md) and [manager dashboard](feature-manager-dashboard.md); staff access uses [authentication and authorization](feature-authentication-authorization.md). Any task action depends on its corresponding domain feature and approved permissions.

## Stack

Laravel and Livewire; Pest and Playwright. AI provider, model, and integrations are not selected.

## Implementation plan and affected files

- Define supported guest/staff questions, languages, knowledge sources, action permissions and confirmations, privacy, model/provider, and failure handling.
- Build separate guest and staff chat surfaces with shared approved service boundaries; authorize any requested domain action using the underlying application's permissions.
- Connect only explicitly approved actions and integrations; show errors or unavailability rather than claiming that an unperformed action succeeded.
- Expected changes: chat views/Livewire components, service interfaces and configuration, authorization, approved integration code, and `tests/`.

## Expected output

- Guest and staff chat can handle the approved use cases in English and German; any supported platform action is permission-checked and its actual outcome is shown.
- Tests cover role boundaries, unapproved actions, provider failures, and correct outcome reporting using controlled test doubles.
- Milestone 1 AI integrations remain mocked or unimplemented. The prototype restaurant-reservation conversation is illustrative, not proof of an integration.

## Decisions and constraints

Provider, model, external services, knowledge handling, supported actions, consent, data retention, and restaurant reservation capabilities require approval.

## Execution checklist

1. Agree on provider, permitted data/knowledge sources, guest versus staff capabilities, consent, retention, and actionable integrations.
2. Define an assistant service interface and separate authorized action adapters; enforce the same domain policies as ordinary users and require any agreed confirmations.
3. Replace mock chat surfaces only after approval, keeping credentials server-side and returning explicit errors for unavailable providers or failed actions.
4. Test language handling, prompt/input boundaries, unauthorized actions, confirmation, provider timeouts, and actual task outcomes with test doubles.

Candidate files: AI service interfaces and approved adapters under `application/app/`, guest and dashboard chat views, environment examples without secrets, and `application/tests/Feature/AssistantTest.php`.

## Status

[ ] Not started
