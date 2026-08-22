# Rehla DataGrid — Design Spec

> **Parent architecture:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`  
> **Execution unit:** `02 / 19`  
> **Status:** Approved decomposition of the Rehla master architecture. This document narrows scope; it does not override the parent spec.


## 1. Goal

Provide a safe reusable server-side DataGrid engine with registered columns, filters, sorting, pagination, actions and export contracts.

## 2. Scope Boundary

**Implementation location:** `packages/Rehla/DataGrid`  
**Direct design dependencies:** `core`

### Owns
- DataGrid base contract
- column registry
- filter registry
- sort allowlist
- search processing
- pagination
- row actions
- mass actions
- export contract
- server-registered grid identity

### Explicitly does not own
- Dashboard Blade rendering
- business-specific grid definitions
- arbitrary HTTP class instantiation

The implementation MUST NOT pull responsibilities from a later package merely to make the current package appear complete. If a downstream feature needs an integration point, expose only the smallest contract required by the parent architecture.

## 3. Public Interfaces

- DataGrid contract
- Column definition
- Filter definition
- GridRegistry
- GridQuery DTO
- GridResult DTO
- Action/MassAction contracts

Public contracts are stable package boundaries. Concrete implementation classes remain internal unless another approved spec explicitly consumes them. Cross-package access to Eloquent models is discouraged when a service/query contract can preserve the boundary.

## 4. Dependency Rules

1. The package may depend only on its approved direct dependencies plus Laravel/framework libraries explicitly justified by this spec.
2. Dependencies must point in one direction; circular Composer or runtime service dependencies are forbidden.
3. Presentation packages may consume domain contracts; domain packages must not call Dashboard or API controllers/views.
4. Existing approved packages may not be redesigned from this unit.
5. A dependency added to Composer requires `composer validate` and an architecture test update.

**Known downstream consumers:** `dashboard-foundation`

## 5. Persistence Ownership

- No package-owned persistence is required by this design unit.

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

- Never accept arbitrary PHP class names from HTTP
- Sort/filter only registered fields
- No raw SQL identifier from user input
- Clamp page size
- Authorize row/mass actions

These invariants are acceptance requirements, not optional hardening tasks.

## 9. Test Strategy

The package must have focused tests for:

- registered sort accepted
- unknown sort rejected
- unknown filter rejected
- injection-like sort/filter input rejected
- grid identity tampering rejected
- unauthorized action rejected
- pagination cap

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

- `packages/Rehla/DataGrid/src/Contracts/DataGridContract.php`
- `packages/Rehla/DataGrid/src/Contracts/FilterContract.php`
- `packages/Rehla/DataGrid/src/Contracts/ExporterContract.php`
- `packages/Rehla/DataGrid/src/Contracts/ActionAuthorizer.php`
- `packages/Rehla/DataGrid/src/GridRegistry.php`
- `packages/Rehla/DataGrid/src/DataGrid.php`
- `packages/Rehla/DataGrid/src/Columns/Column.php`
- `packages/Rehla/DataGrid/src/Filters/Filter.php`
- `packages/Rehla/DataGrid/src/Query/GridQuery.php`
- `packages/Rehla/DataGrid/src/Query/GridQueryProcessor.php`
- `packages/Rehla/DataGrid/src/Results/GridResult.php`
- `packages/Rehla/DataGrid/src/Actions/RowAction.php`
- `packages/Rehla/DataGrid/src/Actions/MassAction.php`

## 11. Out-of-Scope Change Rule

If implementation discovers a requirement that belongs to another unit, record it as a dependency/interface need. Do not implement that other unit early. A real contradiction with the parent spec requires a design amendment before code proceeds.
