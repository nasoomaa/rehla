# Rehla Payment — Design Spec

> **Parent architecture:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`  
> **Execution unit:** `13 / 19`  
> **Status:** Approved decomposition of the Rehla master architecture. This document narrows scope; it does not override the parent spec.


## 1. Goal

Own payment methods, banks, payment records/attempts, private payment proof and independently authorized payment state transitions.

## 2. Scope Boundary

**Implementation location:** `packages/Rehla/Payment`  
**Direct design dependencies:** `core`, `sales`, `media`

### Owns
- Bank
- PaymentMethod
- Payment
- PaymentAttempt
- PaymentStatusHistory
- payment proof reference
- approve/reject workflow
- destination snapshot

### Explicitly does not own
- OrderStatus changes except through explicit integration reaction
- gateway implementations not required by V1

The implementation MUST NOT pull responsibilities from a later package merely to make the current package appear complete. If a downstream feature needs an integration point, expose only the smallest contract required by the parent architecture.

## 3. Public Interfaces

- PaymentRepository
- PaymentSubmissionService
- PaymentReviewService
- PaymentStateMachine

Public contracts are stable package boundaries. Concrete implementation classes remain internal unless another approved spec explicitly consumes them. Cross-package access to Eloquent models is discouraged when a service/query contract can preserve the boundary.

## 4. Dependency Rules

1. The package may depend only on its approved direct dependencies plus Laravel/framework libraries explicitly justified by this spec.
2. Dependencies must point in one direction; circular Composer or runtime service dependencies are forbidden.
3. Presentation packages may consume domain contracts; domain packages must not call Dashboard or API controllers/views.
4. Existing approved packages may not be redesigned from this unit.
5. A dependency added to Composer requires `composer validate` and an architecture test update.

**Known downstream consumers:** `notifications`, `api`, `dashboard-integration`

## 5. Persistence Ownership

- `banks`
- `payment_methods`
- `payments`
- `payment_attempts`
- `payment_status_history`

Migrations live with the package that owns the data. Foreign keys crossing package boundaries are allowed only when the parent architecture explicitly requires a durable relationship; the owning package still controls lifecycle semantics.

## 6. Events and Secondary Reactions

- `PaymentSubmitted`
- `PaymentApproved`
- `PaymentRejected`

Events are used for secondary reactions (notification, audit, integration) and not as invisible replacement for understandable core transaction flow.

## 7. Error and Transaction Semantics

- Domain/infrastructure failures use meaningful exceptions or result objects rather than catch-all `Exception` handling.
- HTTP mapping belongs to Dashboard/API presentation layers, not this package unless this unit itself is a presentation package.
- Atomic multi-write behavior uses a database transaction at the application-service boundary that owns the invariant.
- Retry and idempotency behavior must be explicit where duplicate requests could create duplicated durable state.

## 8. Security Invariants

- Proof private via Media
- Approve/reject requires ACL
- Idempotent transitions
- Unique payment references
- No payment secrets in audit/logs

These invariants are acceptance requirements, not optional hardening tasks.

## 9. Test Strategy

The package must have focused tests for:

- submit proof
- unauthorized proof access denied
- approve/reject authorization
- duplicate transition idempotency
- invalid state transition
- order status remains independent

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

- `packages/Rehla/Payment/src/Contracts/PaymentRepository.php`
- `packages/Rehla/Payment/src/Contracts/PaymentSubmission.php`
- `packages/Rehla/Payment/src/Contracts/PaymentReview.php`
- `packages/Rehla/Payment/src/Database/Migrations/2026_08_22_130001_create_banks_table.php`
- `packages/Rehla/Payment/src/Database/Migrations/2026_08_22_130002_create_payment_methods_table.php`
- `packages/Rehla/Payment/src/Database/Migrations/2026_08_22_130003_create_payments_table.php`
- `packages/Rehla/Payment/src/Database/Migrations/2026_08_22_130004_create_payment_attempts_table.php`
- `packages/Rehla/Payment/src/Database/Migrations/2026_08_22_130005_create_payment_status_history_table.php`
- `packages/Rehla/Payment/src/Models/Bank.php`
- `packages/Rehla/Payment/src/Models/PaymentMethod.php`
- `packages/Rehla/Payment/src/Models/Payment.php`
- `packages/Rehla/Payment/src/Models/PaymentAttempt.php`
- `packages/Rehla/Payment/src/Models/PaymentStatusHistory.php`
- `packages/Rehla/Payment/src/Repositories/EloquentPaymentRepository.php`
- `packages/Rehla/Payment/src/Services/PaymentSubmissionService.php`
- `packages/Rehla/Payment/src/Services/PaymentReviewService.php`
- `packages/Rehla/Payment/src/State/PaymentStatus.php`
- `packages/Rehla/Payment/src/State/PaymentStateMachine.php`
- `packages/Rehla/Payment/src/Events/PaymentSubmitted.php`
- `packages/Rehla/Payment/src/Events/PaymentApproved.php`
- `packages/Rehla/Payment/src/Events/PaymentRejected.php`

## 11. Out-of-Scope Change Rule

If implementation discovers a requirement that belongs to another unit, record it as a dependency/interface need. Do not implement that other unit early. A real contradiction with the parent spec requires a design amendment before code proceeds.
