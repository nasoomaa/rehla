# Rehla CartRule — Design Spec

> **Parent architecture:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`  
> **Execution unit:** `10 / 19`  
> **Status:** Approved decomposition of the Rehla master architecture. This document narrows scope; it does not override the parent spec.


## 1. Goal

Own promotions and coupons using the neutral Rule engine and a CartRuleContext that does not depend on Checkout models.

## 2. Scope Boundary

**Implementation location:** `packages/Rehla/CartRule`  
**Direct design dependencies:** `core`, `rule`, `catalog`, `customers`

### Owns
- CartRule
- Coupon
- rule conditions/actions mapping
- percentage/fixed discounts
- minimum subtotal
- eligibility
- validity
- priority/stop-processing
- max discount
- usage limits
- usage ledger

### Explicitly does not own
- Checkout Cart/CartItem models
- order creation
- catalog-rule

The implementation MUST NOT pull responsibilities from a later package merely to make the current package appear complete. If a downstream feature needs an integration point, expose only the smallest contract required by the parent architecture.

## 3. Public Interfaces

- CartRuleContext DTO
- CartRuleEvaluator
- DiscountResult
- CouponRedemptionService

Public contracts are stable package boundaries. Concrete implementation classes remain internal unless another approved spec explicitly consumes them. Cross-package access to Eloquent models is discouraged when a service/query contract can preserve the boundary.

## 4. Dependency Rules

1. The package may depend only on its approved direct dependencies plus Laravel/framework libraries explicitly justified by this spec.
2. Dependencies must point in one direction; circular Composer or runtime service dependencies are forbidden.
3. Presentation packages may consume domain contracts; domain packages must not call Dashboard or API controllers/views.
4. Existing approved packages may not be redesigned from this unit.
5. A dependency added to Composer requires `composer validate` and an architecture test update.

**Known downstream consumers:** `checkout`, `dashboard-integration`

## 5. Persistence Ownership

- `cart_rules`
- `coupons`
- `cart_rule_conditions/actions representation`
- `coupon/cart_rule usage ledger`

Migrations live with the package that owns the data. Foreign keys crossing package boundaries are allowed only when the parent architecture explicitly requires a durable relationship; the owning package still controls lifecycle semantics.

## 6. Events and Secondary Reactions

- `CouponRedeemed`
- `CartRuleApplied`

Events are used for secondary reactions (notification, audit, integration) and not as invisible replacement for understandable core transaction flow.

## 7. Error and Transaction Semantics

- Domain/infrastructure failures use meaningful exceptions or result objects rather than catch-all `Exception` handling.
- HTTP mapping belongs to Dashboard/API presentation layers, not this package unless this unit itself is a presentation package.
- Atomic multi-write behavior uses a database transaction at the application-service boundary that owns the invariant.
- Retry and idempotency behavior must be explicit where duplicate requests could create duplicated durable state.

## 8. Security Invariants

- No executable expressions
- Concurrency-safe redemption limits
- Context contains server-derived values
- Do not trust client discount amount

These invariants are acceptance requirements, not optional hardening tasks.

## 9. Test Strategy

The package must have focused tests for:

- percentage/fixed discounts
- minimum subtotal
- eligibility
- date validity
- priority
- stop further rules
- max discount
- global/customer usage limits
- concurrent final redemption

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

- `packages/Rehla/CartRule/src/Contracts/CartRuleEvaluator.php`
- `packages/Rehla/CartRule/src/Contracts/CouponRedemption.php`
- `packages/Rehla/CartRule/src/Database/Migrations/2026_08_22_100001_create_cart_rules_table.php`
- `packages/Rehla/CartRule/src/Database/Migrations/2026_08_22_100002_create_coupons_table.php`
- `packages/Rehla/CartRule/src/Database/Migrations/2026_08_22_100003_create_cart_rule_conditions_table.php`
- `packages/Rehla/CartRule/src/Database/Migrations/2026_08_22_100004_create_cart_rule_actions_table.php`
- `packages/Rehla/CartRule/src/Database/Migrations/2026_08_22_100005_create_cart_rule_usage_table.php`
- `packages/Rehla/CartRule/src/Models/CartRule.php`
- `packages/Rehla/CartRule/src/Models/Coupon.php`
- `packages/Rehla/CartRule/src/Models/CartRuleCondition.php`
- `packages/Rehla/CartRule/src/Models/CartRuleAction.php`
- `packages/Rehla/CartRule/src/Models/CartRuleUsage.php`
- `packages/Rehla/CartRule/src/Context/CartRuleContext.php`
- `packages/Rehla/CartRule/src/Results/DiscountResult.php`
- `packages/Rehla/CartRule/src/Services/DefaultCartRuleEvaluator.php`
- `packages/Rehla/CartRule/src/Services/CouponRedemptionService.php`
- `packages/Rehla/CartRule/src/Events/CouponRedeemed.php`
- `packages/Rehla/CartRule/src/Events/CartRuleApplied.php`

## 11. Out-of-Scope Change Rule

If implementation discovers a requirement that belongs to another unit, record it as a dependency/interface need. Do not implement that other unit early. A real contradiction with the parent spec requires a design amendment before code proceeds.
