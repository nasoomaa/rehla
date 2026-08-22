# Rehla Customers — Design Spec

> **Parent architecture:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`  
> **Execution unit:** `08 / 19`  
> **Status:** Approved decomposition of the Rehla master architecture. This document narrows scope; it does not override the parent spec.


## 1. Goal

Own customer identity/profile data and customer-facing authentication domain support used by Checkout and mobile API.

## 2. Scope Boundary

**Implementation location:** `packages/Rehla/Customers`  
**Direct design dependencies:** `core`, `media`

### Owns
- Customer
- profile/contact information
- customer status
- customer authentication domain support
- customer repository/services/events

### Explicitly does not own
- admin users
- orders
- visa applications

The implementation MUST NOT pull responsibilities from a later package merely to make the current package appear complete. If a downstream feature needs an integration point, expose only the smallest contract required by the parent architecture.

## 3. Public Interfaces

- CustomerRepository
- CustomerProfileService
- CustomerIdentity contract

Public contracts are stable package boundaries. Concrete implementation classes remain internal unless another approved spec explicitly consumes them. Cross-package access to Eloquent models is discouraged when a service/query contract can preserve the boundary.

## 4. Dependency Rules

1. The package may depend only on its approved direct dependencies plus Laravel/framework libraries explicitly justified by this spec.
2. Dependencies must point in one direction; circular Composer or runtime service dependencies are forbidden.
3. Presentation packages may consume domain contracts; domain packages must not call Dashboard or API controllers/views.
4. Existing approved packages may not be redesigned from this unit.
5. A dependency added to Composer requires `composer validate` and an architecture test update.

**Known downstream consumers:** `cart-rule`, `checkout`, `sales`, `applications`, `notifications`, `api`, `dashboard-integration`

## 5. Persistence Ownership

- `customers`
- `customer profile/contact tables only if split by approved model`

Migrations live with the package that owns the data. Foreign keys crossing package boundaries are allowed only when the parent architecture explicitly requires a durable relationship; the owning package still controls lifecycle semantics.

## 6. Events and Secondary Reactions

- `CustomerRegistered`
- `CustomerProfileUpdated`
- `CustomerStatusChanged`

Events are used for secondary reactions (notification, audit, integration) and not as invisible replacement for understandable core transaction flow.

## 7. Error and Transaction Semantics

- Domain/infrastructure failures use meaningful exceptions or result objects rather than catch-all `Exception` handling.
- HTTP mapping belongs to Dashboard/API presentation layers, not this package unless this unit itself is a presentation package.
- Atomic multi-write behavior uses a database transaction at the application-service boundary that owns the invariant.
- Retry and idempotency behavior must be explicit where duplicate requests could create duplicated durable state.

## 8. Security Invariants

- password/token fields never serialized
- PII minimized in logs
- customer status enforced by auth/application services

These invariants are acceptance requirements, not optional hardening tasks.

## 9. Test Strategy

The package must have focused tests for:

- customer creation/profile update
- unique identity fields
- status behavior
- secret fields hidden
- repository boundaries

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

- `packages/Rehla/Customers/src/Contracts/CustomerRepository.php`
- `packages/Rehla/Customers/src/Contracts/CustomerIdentity.php`
- `packages/Rehla/Customers/src/Contracts/CustomerProfileService.php`
- `packages/Rehla/Customers/src/Database/Migrations/2026_08_22_080001_create_customers_table.php`
- `packages/Rehla/Customers/src/Models/Customer.php`
- `packages/Rehla/Customers/src/Repositories/EloquentCustomerRepository.php`
- `packages/Rehla/Customers/src/Services/CustomerProfileManager.php`
- `packages/Rehla/Customers/src/Events/CustomerRegistered.php`
- `packages/Rehla/Customers/src/Events/CustomerProfileUpdated.php`
- `packages/Rehla/Customers/src/Events/CustomerStatusChanged.php`

## 11. Out-of-Scope Change Rule

If implementation discovers a requirement that belongs to another unit, record it as a dependency/interface need. Do not implement that other unit early. A real contradiction with the parent spec requires a design amendment before code proceeds.
