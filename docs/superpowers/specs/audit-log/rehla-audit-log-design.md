# Rehla AuditLog — Design Spec

> **Parent architecture:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`  
> **Execution unit:** `16 / 19`  
> **Status:** Approved decomposition of the Rehla master architecture. This document narrows scope; it does not override the parent spec.


## 1. Goal

Record security-relevant administrator/domain changes with actor, entity, request metadata and redacted before/after values.

## 2. Scope Boundary

**Implementation location:** `packages/Rehla/AuditLog`  
**Direct design dependencies:** `core`, `admin-users`

### Owns
- AuditEntry
- audit recorder
- actor resolution
- before/after redaction
- request metadata capture
- audit query contract

### Explicitly does not own
- application debug logging
- notification delivery log

The implementation MUST NOT pull responsibilities from a later package merely to make the current package appear complete. If a downstream feature needs an integration point, expose only the smallest contract required by the parent architecture.

## 3. Public Interfaces

- AuditRecorder
- AuditRedactor
- AuditQueryService

Public contracts are stable package boundaries. Concrete implementation classes remain internal unless another approved spec explicitly consumes them. Cross-package access to Eloquent models is discouraged when a service/query contract can preserve the boundary.

## 4. Dependency Rules

1. The package may depend only on its approved direct dependencies plus Laravel/framework libraries explicitly justified by this spec.
2. Dependencies must point in one direction; circular Composer or runtime service dependencies are forbidden.
3. Presentation packages may consume domain contracts; domain packages must not call Dashboard or API controllers/views.
4. Existing approved packages may not be redesigned from this unit.
5. A dependency added to Composer requires `composer validate` and an architecture test update.

**Known downstream consumers:** `dashboard-integration`

## 5. Persistence Ownership

- `audit_log`

Migrations live with the package that owns the data. Foreign keys crossing package boundaries are allowed only when the parent architecture explicitly requires a durable relationship; the owning package still controls lifecycle semantics.

## 6. Events and Secondary Reactions

- No new domain event is required solely by this unit.

Events are used for secondary reactions (notification, audit, integration) and not as invisible replacement for understandable core transaction flow.

## 7. Error and Transaction Semantics

- Domain/infrastructure failures use meaningful exceptions or result objects rather than catch-all `Exception` handling.
- HTTP mapping belongs to Dashboard/API presentation layers, not this package unless this unit itself is a presentation package.
- Atomic multi-write behavior uses a database transaction at the application-service boundary that owns the invariant.
- Retry and idempotency behavior must be explicit where duplicate requests could create duplicated durable state.

## 8. Security Invariants

- Never store passwords/tokens/secrets/document contents
- Sensitive domain fields redacted or omitted
- Audit writes append-only by application policy
- Restrict audit viewing

These invariants are acceptance requirements, not optional hardening tasks.

## 9. Test Strategy

The package must have focused tests for:

- records actor/action/entity/request ID
- redacts secrets
- redacts application sensitive fields
- records role/payment/application/config/cache actions through integrations
- unauthorized audit query denied

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

- `packages/Rehla/AuditLog/src/Contracts/AuditRecorder.php`
- `packages/Rehla/AuditLog/src/Contracts/AuditQueryService.php`
- `packages/Rehla/AuditLog/src/Database/Migrations/2026_08_22_160001_create_audit_log_table.php`
- `packages/Rehla/AuditLog/src/Models/AuditEntry.php`
- `packages/Rehla/AuditLog/src/Services/DatabaseAuditRecorder.php`
- `packages/Rehla/AuditLog/src/Services/AuditRedactor.php`
- `packages/Rehla/AuditLog/src/Services/DatabaseAuditQueryService.php`
- `packages/Rehla/AuditLog/src/Support/AuditActorResolver.php`

## 11. Out-of-Scope Change Rule

If implementation discovers a requirement that belongs to another unit, record it as a dependency/interface need. Do not implement that other unit early. A real contradiction with the parent spec requires a design amendment before code proceeds.
