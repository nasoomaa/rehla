# Rehla Core — Design Spec

> **Parent architecture:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`  
> **Execution unit:** `01 / 19`  
> **Status:** Approved decomposition of the Rehla master architecture. This document narrows scope; it does not override the parent spec.


## 1. Goal

Provide the business-agnostic kernel consumed by Rehla packages: Menu, ACL, SystemConfig, locale/currency primitives, request correlation and shared application contracts.

## 2. Scope Boundary

**Implementation location:** `packages/Rehla/Core`  
**Direct design dependencies:** `foundation`

### Owns
- Menu registry and menu item contracts
- ACL registry and ACL node contracts
- SystemConfig registry/storage abstraction
- locale infrastructure
- currency infrastructure
- request/correlation IDs
- shared exceptions and support primitives
- base repository primitives only where justified

### Explicitly does not own
- DataGrid
- Rule engine
- Media
- Product/Service
- Cart/Checkout
- Order/Sales
- Payment
- VisaApplication
- Coupon

The implementation MUST NOT pull responsibilities from a later package merely to make the current package appear complete. If a downstream feature needs an integration point, expose only the smallest contract required by the parent architecture.

## 3. Public Interfaces

- `MenuManager::register()/items()`
- `AclManager::register()/allows()`
- SystemConfigRepository contract
- CurrentLocale contract
- Currency/Money support primitives approved by master spec
- RequestId middleware/context

Public contracts are stable package boundaries. Concrete implementation classes remain internal unless another approved spec explicitly consumes them. Cross-package access to Eloquent models is discouraged when a service/query contract can preserve the boundary.

## 4. Dependency Rules

1. The package may depend only on its approved direct dependencies plus Laravel/framework libraries explicitly justified by this spec.
2. Dependencies must point in one direction; circular Composer or runtime service dependencies are forbidden.
3. Presentation packages may consume domain contracts; domain packages must not call Dashboard or API controllers/views.
4. Existing approved packages may not be redesigned from this unit.
5. A dependency added to Composer requires `composer validate` and an architecture test update.

**Known downstream consumers:** `datagrid`, `rule`, `media`, `image-cache`, `dashboard-foundation`, `admin-users`, `customers`, `catalog`, `cart-rule`, `checkout`, `sales`, `payment`, `applications`, `notifications`, `audit-log`, `api`

## 5. Persistence Ownership

- `core_config with non-null locale_code sentinel and UNIQUE(key, locale_code)`
- `locales if persisted by approved design`
- `currencies if persisted by approved design`

Migrations live with the package that owns the data. Foreign keys crossing package boundaries are allowed only when the parent architecture explicitly requires a durable relationship; the owning package still controls lifecycle semantics.

## 6. Events and Secondary Reactions

- `Core configuration changed event where secondary reactions need it`

Events are used for secondary reactions (notification, audit, integration) and not as invisible replacement for understandable core transaction flow.

## 7. Error and Transaction Semantics

- Domain/infrastructure failures use meaningful exceptions or result objects rather than catch-all `Exception` handling.
- HTTP mapping belongs to Dashboard/API presentation layers, not this package unless this unit itself is a presentation package.
- Atomic multi-write behavior uses a database transaction at the application-service boundary that owns the invariant.
- Retry and idempotency behavior must be explicit where duplicate requests could create duplicated durable state.

## 8. Security Invariants

- ACL fails closed for unknown protected ability
- secret SystemConfig values are write-only/redacted on read
- request IDs cannot be supplied as arbitrary trusted audit identity

These invariants are acceptance requirements, not optional hardening tasks.

## 9. Test Strategy

The package must have focused tests for:

- Menu registration and uniqueness
- ACL registration/unknown key behavior
- SystemConfig locale fallback and uniqueness
- secret redaction
- locale direction
- currency primitives
- architecture test proving no business package dependency

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

- `packages/Rehla/Core/src/Contracts/MenuRegistry.php`
- `packages/Rehla/Core/src/Contracts/AclRegistry.php`
- `packages/Rehla/Core/src/Contracts/SystemConfigRepository.php`
- `packages/Rehla/Core/src/Contracts/CurrentLocale.php`
- `packages/Rehla/Core/src/Contracts/CurrentCurrency.php`
- `packages/Rehla/Core/src/Database/Migrations/2026_08_22_010001_create_core_config_table.php`
- `packages/Rehla/Core/src/Database/Migrations/2026_08_22_010002_create_locales_table.php`
- `packages/Rehla/Core/src/Database/Migrations/2026_08_22_010003_create_currencies_table.php`
- `packages/Rehla/Core/src/Models/CoreConfig.php`
- `packages/Rehla/Core/src/Models/Locale.php`
- `packages/Rehla/Core/src/Models/Currency.php`
- `packages/Rehla/Core/src/Menu/MenuManager.php`
- `packages/Rehla/Core/src/Acl/AclManager.php`
- `packages/Rehla/Core/src/SystemConfig/SystemConfigManager.php`
- `packages/Rehla/Core/src/SystemConfig/DatabaseSystemConfigRepository.php`
- `packages/Rehla/Core/src/Support/RequestId.php`
- `packages/Rehla/Core/src/Http/Middleware/EnsureRequestId.php`
- `packages/Rehla/Core/src/Events/SystemConfigChanged.php`

## 11. Out-of-Scope Change Rule

If implementation discovers a requirement that belongs to another unit, record it as a dependency/interface need. Do not implement that other unit early. A real contradiction with the parent spec requires a design amendment before code proceeds.
