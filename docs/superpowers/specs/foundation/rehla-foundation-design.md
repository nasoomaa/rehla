# Rehla Foundation — Design Spec

> **Parent architecture:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`  
> **Execution unit:** `00 / 19`  
> **Status:** Approved decomposition of the Rehla master architecture. This document narrows scope; it does not override the parent spec.
> **Path convention amendment (approved 2026-08-23):** Filesystem package paths use lowercase `packages/rehla/*`; PHP namespaces remain PascalCase.


## 1. Goal

Establish the Laravel 13/PHP 8.5 monorepo foundation, deterministic first-party package loading, PostgreSQL/test/frontend conventions, and architecture quality gates before any Rehla domain package is implemented.

## 2. Scope Boundary

**Implementation location:** `repository root / application infrastructure`  
**Direct design dependencies:** None beyond the repository baseline.

### Owns
- Laravel application baseline
- root Composer monorepo/path repository conventions
- first-party provider registry/order
- PostgreSQL baseline and test database conventions
- Pest and package Testbench conventions
- architecture-test harness
- Pint/static-analysis baseline
- Vite + Tailwind + Alpine baseline
- Playwright baseline
- safe environment and secret-handling conventions

### Explicitly does not own
- Core business/infrastructure engines
- all domain models
- Dashboard feature screens
- API feature endpoints

The implementation MUST NOT pull responsibilities from a later package merely to make the current package appear complete. If a downstream feature needs an integration point, expose only the smallest contract required by the parent architecture.

## 3. Public Interfaces

- Root Composer path repositories for packages/rehla/*
- deterministic first-party provider registration contract
- shared test bootstrap conventions
- architecture dependency manifest convention
- frontend build entrypoint convention

Public contracts are stable package boundaries. Concrete implementation classes remain internal unless another approved spec explicitly consumes them. Cross-package access to Eloquent models is discouraged when a service/query contract can preserve the boundary.

## 4. Dependency Rules

1. The package may depend only on its approved direct dependencies plus Laravel/framework libraries explicitly justified by this spec.
2. Dependencies must point in one direction; circular Composer or runtime service dependencies are forbidden.
3. Presentation packages may consume domain contracts; domain packages must not call Dashboard or API controllers/views.
4. Existing approved packages may not be redesigned from this unit.
5. A dependency added to Composer requires `composer validate` and an architecture test update.

**Known downstream consumers:** `core`

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

- Never print secret environment values
- Test database must be isolated from production
- No destructive DB reset may target a non-test connection
- Dependency versions must be compatible with PHP 8.5.4 and Laravel 13

These invariants are acceptance requirements, not optional hardening tasks.

## 9. Test Strategy

The package must have focused tests for:

- application boots on PHP 8.5/Laravel 13
- Composer validates
- baseline Pest suite runs
- architecture harness can assert package dependencies
- Vite production build succeeds
- Playwright can start against test app

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

## 11. Out-of-Scope Change Rule

If implementation discovers a requirement that belongs to another unit, record it as a dependency/interface need. Do not implement that other unit early. A real contradiction with the parent spec requires a design amendment before code proceeds.
