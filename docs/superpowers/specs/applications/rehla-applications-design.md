# Rehla Applications — Design Spec

> **Parent architecture:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`  
> **Execution unit:** `14 / 19`  
> **Status:** Approved decomposition of the Rehla master architecture. This document narrows scope; it does not override the parent spec.


## 1. Goal

Own the Umrah visa application workflow, applicants/travellers, passport/identity data, private documents, review and processing status independent of order/payment status.

## 2. Scope Boundary

**Implementation location:** `packages/Rehla/Applications`  
**Direct design dependencies:** `core`, `sales`, `customers`, `media`

### Owns
- VisaApplication
- Applicant
- passport/identity data
- ApplicationDocument
- ApplicationStatus
- ApplicationStatusHistory
- review/processing notes
- order/order-item association

### Explicitly does not own
- Order lifecycle
- Payment lifecycle
- generic media storage mechanics

The implementation MUST NOT pull responsibilities from a later package merely to make the current package appear complete. If a downstream feature needs an integration point, expose only the smallest contract required by the parent architecture.

## 3. Public Interfaces

- ApplicationRepository
- ApplicationService
- ApplicationReviewService
- ApplicationStateMachine
- TravellerDocumentService

Public contracts are stable package boundaries. Concrete implementation classes remain internal unless another approved spec explicitly consumes them. Cross-package access to Eloquent models is discouraged when a service/query contract can preserve the boundary.

## 4. Dependency Rules

1. The package may depend only on its approved direct dependencies plus Laravel/framework libraries explicitly justified by this spec.
2. Dependencies must point in one direction; circular Composer or runtime service dependencies are forbidden.
3. Presentation packages may consume domain contracts; domain packages must not call Dashboard or API controllers/views.
4. Existing approved packages may not be redesigned from this unit.
5. A dependency added to Composer requires `composer validate` and an architecture test update.

**Known downstream consumers:** `notifications`, `api`, `dashboard-integration`

## 5. Persistence Ownership

- `visa_applications`
- `applicants`
- `application_documents`
- `application_status_history`

Migrations live with the package that owns the data. Foreign keys crossing package boundaries are allowed only when the parent architecture explicitly requires a durable relationship; the owning package still controls lifecycle semantics.

## 6. Events and Secondary Reactions

- `ApplicationCreated`
- `ApplicationStatusChanged`
- `ApplicationDocumentAdded`

Events are used for secondary reactions (notification, audit, integration) and not as invisible replacement for understandable core transaction flow.

## 7. Error and Transaction Semantics

- Domain/infrastructure failures use meaningful exceptions or result objects rather than catch-all `Exception` handling.
- HTTP mapping belongs to Dashboard/API presentation layers, not this package unless this unit itself is a presentation package.
- Atomic multi-write behavior uses a database transaction at the application-service boundary that owns the invariant.
- Retry and idempotency behavior must be explicit where duplicate requests could create duplicated durable state.

## 8. Security Invariants

- Passport/identity values protected from logs
- Documents private
- Application ACL separated view/update/review
- State transitions explicit
- Minimize audit before/after sensitive payloads

These invariants are acceptance requirements, not optional hardening tasks.

## 9. Test Strategy

The package must have focused tests for:

- create linked application
- applicant data validation
- private document authorization
- valid/invalid state transition
- history append
- status independence from order/payment
- log redaction

Testing follows strict TDD for behavior: RED → verify RED → GREEN → verify GREEN → REFACTOR → verify. Generated/configuration-only files are exempt only where the Superpowers TDD skill permits it.

## 10. Acceptance Gate

This unit may be considered complete only when all of the following hold:

- [ ] Every owned responsibility above has a concrete implementation or intentionally small extension point justified by this spec.
- [ ] No explicitly excluded responsibility leaked into the unit.
- [ ] Direct dependencies match this document and architecture tests.
- [ ] Focused tests pass with fresh output.
- [ ] Relevant broader/architecture tests pass with fresh output.
- [ ] Static analysis/formatting applicable to touched PHP code passes.
- [ ] `composer validate` passes if Composer metadata changed.
- [ ] Migrations can be exercised safely if persistence changed.
- [ ] Security invariants have executable regression coverage where technically testable.
- [ ] No secrets or sensitive document contents are present in logs, fixtures, reports, or commits.

## Concrete V1 File Blueprint

The implementation plan uses the following exact V1 target files. Adding another production file requires an explicit responsibility not already represented here; removing one requires a spec amendment.

- `packages/Rehla/Applications/src/Contracts/ApplicationRepository.php`
- `packages/Rehla/Applications/src/Contracts/ApplicationReview.php`
- `packages/Rehla/Applications/src/Contracts/TravellerDocumentService.php`
- `packages/Rehla/Applications/src/Database/Migrations/2026_08_22_140001_create_visa_applications_table.php`
- `packages/Rehla/Applications/src/Database/Migrations/2026_08_22_140002_create_applicants_table.php`
- `packages/Rehla/Applications/src/Database/Migrations/2026_08_22_140003_create_application_documents_table.php`
- `packages/Rehla/Applications/src/Database/Migrations/2026_08_22_140004_create_application_status_history_table.php`
- `packages/Rehla/Applications/src/Models/VisaApplication.php`
- `packages/Rehla/Applications/src/Models/Applicant.php`
- `packages/Rehla/Applications/src/Models/ApplicationDocument.php`
- `packages/Rehla/Applications/src/Models/ApplicationStatusHistory.php`
- `packages/Rehla/Applications/src/Repositories/EloquentApplicationRepository.php`
- `packages/Rehla/Applications/src/Services/ApplicationService.php`
- `packages/Rehla/Applications/src/Services/ApplicationReviewService.php`
- `packages/Rehla/Applications/src/Services/DefaultTravellerDocumentService.php`
- `packages/Rehla/Applications/src/State/ApplicationStatus.php`
- `packages/Rehla/Applications/src/State/ApplicationStateMachine.php`
- `packages/Rehla/Applications/src/Events/ApplicationCreated.php`
- `packages/Rehla/Applications/src/Events/ApplicationStatusChanged.php`
- `packages/Rehla/Applications/src/Events/ApplicationDocumentAdded.php`

## 11. Out-of-Scope Change Rule

If implementation discovers a requirement that belongs to another unit, record it as a dependency/interface need. Do not implement that other unit early. A real contradiction with the parent spec requires a design amendment before code proceeds.
