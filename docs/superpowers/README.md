# Rehla Superpowers Workspace

This directory decomposes the approved Rehla platform architecture into independent Superpowers execution units. The master architecture remains:

`specs/2026-08-22-rehla-platform-design.md`

## Rule of execution

Never execute the whole platform from one giant plan. Each unit follows:

`brainstorming/design spec → writing-plans → isolated worktree → subagent-driven-development → TDD → task review → final review → verification-before-completion → finishing-a-development-branch`

The design specs and implementation plans in this workspace are already decomposed from the approved master architecture. Before code execution, an agent still reads the specific spec/plan and inspects repository reality.

## Runtime baseline

- PHP 8.5.4
- Composer 2.9.5
- Laravel 13.x
- PostgreSQL
- Blade + Tailwind CSS + Alpine.js + Vite
- Pest/Testbench
- Playwright for Admin E2E
- Flutter consumes API V1

## Execution units

| # | Unit | Design | Plan |
|---:|---|---|---|
| 00 | Rehla Foundation | `specs/foundation/rehla-foundation-design.md` | `plans/foundation/rehla-foundation-implementation.md` |
| 01 | Rehla Core | `specs/core/rehla-core-design.md` | `plans/core/rehla-core-implementation.md` |
| 02 | Rehla DataGrid | `specs/datagrid/rehla-datagrid-design.md` | `plans/datagrid/rehla-datagrid-implementation.md` |
| 03 | Rehla Rule | `specs/rule/rehla-rule-design.md` | `plans/rule/rehla-rule-implementation.md` |
| 04 | Rehla Media | `specs/media/rehla-media-design.md` | `plans/media/rehla-media-implementation.md` |
| 05 | Rehla ImageCache | `specs/image-cache/rehla-image-cache-design.md` | `plans/image-cache/rehla-image-cache-implementation.md` |
| 06 | Rehla Dashboard Foundation | `specs/dashboard-foundation/rehla-dashboard-foundation-design.md` | `plans/dashboard-foundation/rehla-dashboard-foundation-implementation.md` |
| 07 | Rehla AdminUsers | `specs/admin-users/rehla-admin-users-design.md` | `plans/admin-users/rehla-admin-users-implementation.md` |
| 08 | Rehla Customers | `specs/customers/rehla-customers-design.md` | `plans/customers/rehla-customers-implementation.md` |
| 09 | Rehla Catalog | `specs/catalog/rehla-catalog-design.md` | `plans/catalog/rehla-catalog-implementation.md` |
| 10 | Rehla CartRule | `specs/cart-rule/rehla-cart-rule-design.md` | `plans/cart-rule/rehla-cart-rule-implementation.md` |
| 11 | Rehla Checkout | `specs/checkout/rehla-checkout-design.md` | `plans/checkout/rehla-checkout-implementation.md` |
| 12 | Rehla Sales | `specs/sales/rehla-sales-design.md` | `plans/sales/rehla-sales-implementation.md` |
| 13 | Rehla Payment | `specs/payment/rehla-payment-design.md` | `plans/payment/rehla-payment-implementation.md` |
| 14 | Rehla Applications | `specs/applications/rehla-applications-design.md` | `plans/applications/rehla-applications-implementation.md` |
| 15 | Rehla Notifications | `specs/notifications/rehla-notifications-design.md` | `plans/notifications/rehla-notifications-implementation.md` |
| 16 | Rehla AuditLog | `specs/audit-log/rehla-audit-log-design.md` | `plans/audit-log/rehla-audit-log-implementation.md` |
| 17 | Rehla API V1 | `specs/api/rehla-api-design.md` | `plans/api/rehla-api-implementation.md` |
| 18 | Rehla Dashboard Domain Integration | `specs/dashboard-integration/rehla-dashboard-integration-design.md` | `plans/dashboard-integration/rehla-dashboard-integration-implementation.md` |
| 19 | Rehla Release Hardening | `specs/release-hardening/rehla-release-hardening-design.md` | `plans/release-hardening/rehla-release-hardening-implementation.md` |


## Hard boundaries

- Core contains no business domain logic.
- DataGrid and Rule are independent packages.
- CartRule does not depend on Checkout internals.
- Checkout owns cart/transaction; Sales owns established orders.
- OrderStatus, PaymentStatus and ApplicationStatus remain independent.
- Media separates private/public; ImageCache serves only eligible public media.
- Dashboard and API are presentation layers.
- Every protected admin route must map to explicit ACL.
- No completion claim without fresh verification evidence.
