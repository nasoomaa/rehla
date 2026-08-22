# Rehla AdminUsers — Design Spec

> **Parent architecture:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`  
> **Execution unit:** `07 / 19`  
> **Status:** Approved decomposition of the Rehla master architecture. This document narrows scope; it does not override the parent spec.


## 1. Goal

Own administrator identities, roles, permission assignment, dedicated admin authentication support, 2FA and backup-code domain behavior.

## 2. Scope Boundary

**Implementation location:** `packages/Rehla/AdminUsers`  
**Direct design dependencies:** `core`

### Owns
- AdminUser
- Role/permission assignment integration
- admin guard provider/domain support
- 2FA secrets and backup codes
- admin account status/security policy

### Explicitly does not own
- customer authentication
- Dashboard presentation components except integration controllers/views

The implementation MUST NOT pull responsibilities from a later package merely to make the current package appear complete. If a downstream feature needs an integration point, expose only the smallest contract required by the parent architecture.

## 3. Public Interfaces

- AdminUserRepository
- AdminAuthenticationService
- TwoFactorService
- RoleAssignmentService

Public contracts are stable package boundaries. Concrete implementation classes remain internal unless another approved spec explicitly consumes them. Cross-package access to Eloquent models is discouraged when a service/query contract can preserve the boundary.

## 4. Dependency Rules

1. The package may depend only on its approved direct dependencies plus Laravel/framework libraries explicitly justified by this spec.
2. Dependencies must point in one direction; circular Composer or runtime service dependencies are forbidden.
3. Presentation packages may consume domain contracts; domain packages must not call Dashboard or API controllers/views.
4. Existing approved packages may not be redesigned from this unit.
5. A dependency added to Composer requires `composer validate` and an architecture test update.

**Known downstream consumers:** `audit-log`, `dashboard-integration`

## 5. Persistence Ownership

- `admin_users`
- `roles/permissions tables from chosen Spatie integration`
- `admin 2FA/backup-code persistence as approved`

Migrations live with the package that owns the data. Foreign keys crossing package boundaries are allowed only when the parent architecture explicitly requires a durable relationship; the owning package still controls lifecycle semantics.

## 6. Events and Secondary Reactions

- `AdminUserCreated`
- `AdminRoleChanged`
- `AdminTwoFactorChanged`

Events are used for secondary reactions (notification, audit, integration) and not as invisible replacement for understandable core transaction flow.

## 7. Error and Transaction Semantics

- Domain/infrastructure failures use meaningful exceptions or result objects rather than catch-all `Exception` handling.
- HTTP mapping belongs to Dashboard/API presentation layers, not this package unless this unit itself is a presentation package.
- Atomic multi-write behavior uses a database transaction at the application-service boundary that owns the invariant.
- Retry and idempotency behavior must be explicit where duplicate requests could create duplicated durable state.

## 8. Security Invariants

- Dedicated admin guard
- password hashing
- session regeneration
- login throttling
- 2FA secret encryption
- backup code hashing
- role changes audited later

These invariants are acceptance requirements, not optional hardening tasks.

## 9. Test Strategy

The package must have focused tests for:

- admin guard isolation
- valid/invalid login
- session regeneration
- role assignment
- 2FA challenge
- backup code one-time use
- disabled admin denied

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

- `packages/Rehla/AdminUsers/src/Contracts/AdminUserRepository.php`
- `packages/Rehla/AdminUsers/src/Contracts/AdminAuthenticator.php`
- `packages/Rehla/AdminUsers/src/Contracts/TwoFactorManager.php`
- `packages/Rehla/AdminUsers/src/Contracts/RoleAssignment.php`
- `packages/Rehla/AdminUsers/src/Database/Migrations/2026_08_22_070001_create_admin_users_table.php`
- `packages/Rehla/AdminUsers/src/Database/Migrations/2026_08_22_070002_add_two_factor_columns_to_admin_users_table.php`
- `packages/Rehla/AdminUsers/src/Database/Migrations/2026_08_22_070003_create_permission_tables.php`
- `packages/Rehla/AdminUsers/src/Models/AdminUser.php`
- `packages/Rehla/AdminUsers/src/Repositories/EloquentAdminUserRepository.php`
- `packages/Rehla/AdminUsers/src/Services/AdminAuthenticationService.php`
- `packages/Rehla/AdminUsers/src/Services/TwoFactorService.php`
- `packages/Rehla/AdminUsers/src/Services/RoleAssignmentService.php`
- `packages/Rehla/AdminUsers/src/Events/AdminUserCreated.php`
- `packages/Rehla/AdminUsers/src/Events/AdminRoleChanged.php`
- `packages/Rehla/AdminUsers/src/Events/AdminTwoFactorChanged.php`

## 11. Out-of-Scope Change Rule

If implementation discovers a requirement that belongs to another unit, record it as a dependency/interface need. Do not implement that other unit early. A real contradiction with the parent spec requires a design amendment before code proceeds.
