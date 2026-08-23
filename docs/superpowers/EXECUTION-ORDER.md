# Rehla Execution Order and Gates

The order below is dependency-driven. A unit starts only after its direct dependency units have passed their completion gates and their integration choice has produced an accessible base for the next worktree.

| Order | Unit | Direct prerequisites | Gate before next unit |
|---:|---|---|---|
| 00 | `foundation` | none | focused tests + architecture gate + review + fresh verification |
| 01 | `core` | foundation | focused tests + architecture gate + review + fresh verification |
| 02 | `datagrid` | core | focused tests + architecture gate + review + fresh verification |
| 03 | `rule` | core | focused tests + architecture gate + review + fresh verification |
| 04 | `media` | core | focused tests + architecture gate + review + fresh verification |
| 05 | `image-cache` | core, media | focused tests + architecture gate + review + fresh verification |
| 06 | `dashboard-foundation` | core, datagrid, media, image-cache | focused tests + architecture gate + review + fresh verification |
| 07 | `admin-users` | core | focused tests + architecture gate + review + fresh verification |
| 08 | `customers` | core, media | focused tests + architecture gate + review + fresh verification |
| 09 | `catalog` | core, media, image-cache | focused tests + architecture gate + review + fresh verification |
| 10 | `cart-rule` | core, rule, catalog, customers | focused tests + architecture gate + review + fresh verification |
| 11 | `checkout` | core, customers, catalog, cart-rule | focused tests + architecture gate + review + fresh verification |
| 12 | `sales` | core, customers, catalog, checkout | focused tests + architecture gate + review + fresh verification |
| 13 | `payment` | core, sales, media | focused tests + architecture gate + review + fresh verification |
| 14 | `applications` | core, sales, customers, media | focused tests + architecture gate + review + fresh verification |
| 15 | `notifications` | core, customers, sales, payment, applications | focused tests + architecture gate + review + fresh verification |
| 16 | `audit-log` | core, admin-users | focused tests + architecture gate + review + fresh verification |
| 17 | `api` | core, customers, catalog, checkout, sales, payment, applications, media | focused tests + architecture gate + review + fresh verification |
| 18 | `dashboard-integration` | dashboard-foundation, admin-users, customers, catalog, cart-rule, sales, payment, applications, audit-log | focused tests + architecture gate + review + fresh verification |
| 19 | `release-hardening` | all previous units | focused tests + architecture gate + review + fresh verification |


## Parallelism policy

Default to sequential execution because packages form an intentional DAG. Parallel execution is allowed only after `superpowers:dispatching-parallel-agents` proves there are no shared files, unresolved shared interfaces, unfinished prerequisite packages, or shared migrations. Do not parallelize Checkout/Sales/Payment/Applications merely for speed.

## Suggested safe opportunities after prerequisites stabilize

- AdminUsers and Customers can be considered for parallel *investigation/design* after Dashboard Foundation/Core are stable, but implementation still requires checking shared auth/bootstrap files.
- Notifications and AuditLog may be parallelizable after their consumed domain event contracts are stable.
- Release hardening is never parallelized as independent fixes until failures are classified by root cause/domain.

## Failure rule

Any test/build/runtime failure activates `superpowers:systematic-debugging`. Do not stack speculative fixes. Establish root cause, create a failing regression test, then use TDD for the fix.


_____________________


الترتيب الموجود في `manifest.json` و`EXECUTION-ORDER.md` هو **00 → 19**، وكل Unit لا تبدأ إلا بعد نجاح Gate الخاصة باعتمادياتها.  

وبما أن الـSpecs والـPlans موجودة بالفعل، فالطريقة الصحيحة لكل مرحلة هي:

**Prompt S = مراجعة الـSpec قبل التنفيذ** → إذا لم يوجد تعارض لا تغيّرها.
**Prompt E = تنفيذ الـPlan** → ويشمل preflight review؛ إذا اكتشف أن الـPlan لا يطابق الـSpec، يستخدم `writing-plans` لتصحيحه ويتوقف قبل التنفيذ. وهذا يتطابق مع الـRunbook الذي أنشأناه. 

---

# 00 — Foundation

## S00 — Review Foundation Spec

```text
Use Superpowers.

We are preparing execution unit 00: REHLA FOUNDATION.

Read completely:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/foundation/rehla-foundation-design.md

Also inspect:

docs/superpowers/plans/foundation/rehla-foundation-implementation.md

Inspect the actual repository before making any recommendation:

- git status
- current branch
- recent commits
- composer.json
- composer.lock
- PHP version
- Composer version
- Laravel version
- package.json
- Vite configuration
- current tests
- existing packages
- database configuration without printing secrets

Runtime target:

PHP 8.5.4
Composer 2.9.5
Laravel 13.x
PostgreSQL
Blade + Tailwind CSS + Alpine.js + Vite
Pest
Playwright

Do NOT implement code.

Determine whether the existing Foundation specification is still correct for
the real repository.

If repository evidence does NOT conflict with the approved design:
- do not rewrite the spec
- report that the spec remains authoritative
- identify the Foundation Gate that must pass before Core starts

If a material architectural conflict exists:
- use superpowers:brainstorming
- explain the exact conflict
- propose the smallest compliant correction
- update only the Foundation spec after the design approval gate
- do not implement anything

Do not redesign future Rehla packages.
```

## E00 — Execute Foundation

```text
Use superpowers:subagent-driven-development.

Execute exactly:

docs/superpowers/plans/foundation/rehla-foundation-implementation.md

Binding specifications:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/foundation/rehla-foundation-design.md

Before implementation:

1. Read both specs and the complete implementation plan.
2. Critically compare the plan to the specs.
3. If the plan materially conflicts with the specs, use
   superpowers:writing-plans to correct the plan and STOP for review.
4. Use superpowers:using-git-worktrees to create or verify an isolated
   workspace.
5. Verify the clean repository baseline.
6. Do not expose environment secret values.

Runtime:

PHP 8.5.4
Composer 2.9.5
Laravel 13.x
PostgreSQL

Execute every task exactly using:

RED
→ verify RED
→ GREEN
→ verify GREEN
→ REFACTOR
→ verify
→ task review
→ commit

Maintain the plan-specific SDD ledger.

Do not implement Core, DataGrid, Dashboard or any other Rehla package.

For failures use superpowers:systematic-debugging before attempting fixes.

At completion:

- run Foundation focused tests
- run architecture tests
- run composer validate
- run relevant static analysis
- verify Laravel bootstrap
- inspect git diff/status
- perform whole-unit code review
- use superpowers:verification-before-completion

Do not claim Foundation complete without fresh evidence.

Then use superpowers:finishing-a-development-branch.

Do not merge or push automatically.
```

---

# 01 — Core

الـCore يعتمد فقط على نجاح Foundation. 

## S01 — Review Core Spec

```text
Use Superpowers.

Review execution unit 01: REHLA CORE.

Read completely:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/foundation/rehla-foundation-design.md
docs/superpowers/specs/core/rehla-core-design.md
docs/superpowers/plans/core/rehla-core-implementation.md

Inspect the completed Foundation implementation.

Do NOT implement code.

Verify that Rehla Core remains strictly business-agnostic.

Core may own infrastructure such as:

- Menu
- ACL
- SystemConfig
- locale
- currency
- common contracts
- request/correlation IDs
- infrastructure exceptions
- common support primitives

Core must NOT own:

- DataGrid
- Rule engine
- Media
- Catalog
- Product/Service business logic
- Cart
- Checkout
- Order
- Payment
- VisaApplication
- CartRule/Coupon

Check the public interfaces and dependencies against the implemented Foundation.

If the design remains valid, do not rewrite it.

If repository evidence creates a material design conflict:
use superpowers:brainstorming and resolve only that conflict through the
design approval gate.

Do not implement Core during this review.
```

## E01 — Execute Core

```text
Use superpowers:subagent-driven-development.

Execute exactly:

docs/superpowers/plans/core/rehla-core-implementation.md

Binding specs:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/foundation/rehla-foundation-design.md
docs/superpowers/specs/core/rehla-core-design.md

Foundation must already have passed its completion gate.

Preflight:

- read specs and plan completely
- verify current base contains approved Foundation
- critically check plan/spec consistency
- if material mismatch exists, correct the plan through
  superpowers:writing-plans and STOP
- use superpowers:using-git-worktrees
- run clean baseline tests

Implement ONLY Rehla Core.

Strictly enforce:

Core contains no business-domain logic.
DataGrid, Rule and Media remain separate future packages.

Use TDD task-by-task:

RED → verify RED → GREEN → verify GREEN → REFACTOR → verify.

Perform task review after each task.

Run architecture-boundary tests whenever dependency rules change.

Use systematic-debugging for any failure.

At the Core Gate run fresh:

- Core package tests
- architecture tests
- Composer validation if metadata changed
- static analysis
- application bootstrap checks
- git diff/status
- final whole-unit code review

Use verification-before-completion.

Only after fresh evidence may the Core Gate be considered passed.

Finish through finishing-a-development-branch.
Do not merge/push automatically.
```

---

# 02 — DataGrid

Dependencies: `Core`. 

## S02

```text
Use Superpowers.

Review execution unit 02: REHLA DATAGRID.

Read:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/core/rehla-core-design.md
docs/superpowers/specs/datagrid/rehla-datagrid-design.md
docs/superpowers/plans/datagrid/rehla-datagrid-implementation.md

Inspect the implemented Core package.

Do not implement code.

Verify the design covers:

- registered columns
- filters
- search
- allowlisted sorting
- pagination
- row actions
- mass actions
- query processing
- grid identities/registry
- authorization integration points
- export contracts where approved

Security invariants:

- no arbitrary SQL identifiers
- no user-controlled PHP class names
- no arbitrary DataGrid class instantiation
- no unregistered filters/sorts

Dashboard UI does not belong in DataGrid.

If the spec still matches repository reality, leave it unchanged.

For any material architectural conflict use superpowers:brainstorming and
resolve it before implementation.
```

## E02

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/datagrid/rehla-datagrid-implementation.md

Binding specs:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/core/rehla-core-design.md
docs/superpowers/specs/datagrid/rehla-datagrid-design.md

Core Gate must already be passed.

Preflight-review the plan against the specs.
If materially inconsistent, revise it using superpowers:writing-plans and STOP.

Use an isolated worktree.

Implement ONLY packages/Rehla/DataGrid and explicitly approved integration
points.

Use strict TDD.

Security tests must include:

- invalid sort fields
- invalid filters
- manipulated grid identity
- unauthorized actions
- injection-like values

Never create an endpoint accepting an arbitrary class name.

Task review after every task.
Use systematic-debugging on failures.

Final Gate:

- DataGrid tests
- security regression tests
- architecture tests
- static analysis
- relevant integration tests
- git diff/status
- final code review
- verification-before-completion

Finish through finishing-a-development-branch.
Do not merge automatically.
```

---

# 03 — Rule

## S03

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/core/rehla-core-design.md
docs/superpowers/specs/rule/rehla-rule-design.md
docs/superpowers/plans/rule/rehla-rule-implementation.md

This is execution unit 03: REHLA RULE.

Inspect implemented Core.

Do not implement.

Confirm Rule remains business-neutral and contains:

- rule context contracts
- conditions
- nested condition groups
- ALL / ANY semantics
- safe operator registry
- evaluator
- results/errors

Explicitly reject:

- eval()
- arbitrary PHP expressions
- executable user content
- CartRule/Coupon business logic

CartRule will consume Rule later.

If no material conflict exists, preserve the spec unchanged.
If one exists, resolve through superpowers:brainstorming and approval before
implementation.
```

## E03

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/rule/rehla-rule-implementation.md

Read:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/core/rehla-core-design.md
docs/superpowers/specs/rule/rehla-rule-design.md

Core must be green.

Preflight-review plan/spec consistency.
If the plan requires material correction, use writing-plans and STOP.

Use an isolated worktree.

Implement only Rehla Rule.

Use strict TDD for:
ALL groups
ANY groups
nested conditions
operators
invalid operators
invalid context values

No CartRule implementation.

Review every task.
Use systematic-debugging for failures.

Finish only after fresh package, architecture and security verification,
whole-unit review, and verification-before-completion.

Use finishing-a-development-branch.
Do not merge automatically.
```

---

# 04 — Media

## S04

```text
Use Superpowers.

Review execution unit 04: REHLA MEDIA.

Read:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/core/rehla-core-design.md
docs/superpowers/specs/media/rehla-media-design.md
docs/superpowers/plans/media/rehla-media-implementation.md

Inspect Core and filesystem configuration.

Do not implement.

Confirm the design safely supports:

- Media UUID identifiers
- public/private classification
- upload validation
- MIME validation
- file-size restrictions
- checksums
- private storage
- authorization contracts
- secure download
- cleanup lifecycle

Sensitive files such as passports, identity files, visa documents and payment
proofs must be private by default.

Image transformations do NOT belong to Media.

Raw filesystem paths must never become authorization credentials.

If repository reality creates a material conflict, use brainstorming.
Otherwise preserve the approved spec.
```

## E04

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/media/rehla-media-implementation.md

Binding specs:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/core/rehla-core-design.md
docs/superpowers/specs/media/rehla-media-design.md

Core Gate must pass first.

Review plan/spec consistency before implementation.
Correct material plan defects with writing-plans and STOP before execution.

Use a worktree.
Use TDD.

Implement only Rehla Media.

Mandatory tests include:

- private media authorization
- MIME validation
- file-size validation
- invalid media IDs
- unauthorized downloads
- traversal/path manipulation
- public/private boundaries

Never expose private storage through the public web root.

Perform task review after every task.

Use systematic-debugging for failures.

At completion run fresh Media/security/architecture tests and final code review,
then verification-before-completion.

Finish branch using finishing-a-development-branch.
```

---

# 05 — ImageCache

Dependencies: Core + Media. 

## S05

```text
Use Superpowers.

Review execution unit 05: REHLA IMAGE CACHE.

Read:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/core/rehla-core-design.md
docs/superpowers/specs/media/rehla-media-design.md
docs/superpowers/specs/image-cache/rehla-image-cache-design.md
docs/superpowers/plans/image-cache/rehla-image-cache-implementation.md

Inspect the actual Media implementation.

Do not implement.

Confirm ImageCache:

- consumes Media safely
- uses registered presets
- resolves media by stable ID/UUID
- accepts only eligible public images
- has deterministic cache keys/invalidation
- never accepts raw filesystem paths
- cannot expose private Media
- blocks traversal

If valid, preserve spec.
Use brainstorming only for material conflicts.
```

## E05

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/image-cache/rehla-image-cache-implementation.md

Required completed dependencies:

Core
Media

Read master, Media and ImageCache specs first.

Review the plan before code.
If materially inconsistent, use writing-plans and STOP.

Use isolated worktree and strict TDD.

Implement only ImageCache and explicitly approved Media integration.

Required regression/security tests:

- allowed preset
- unknown preset rejected
- public media works
- private media rejected
- raw path rejected
- ../ traversal rejected
- cache invalidation/version behavior

Do not add generic arbitrary transformation commands.

Task review after each task.
Use systematic-debugging for failures.

Run final ImageCache + Media integration + architecture + security tests,
whole-unit review and verification-before-completion.

Finish branch without automatic merge.
```

---

# 06 — Dashboard Foundation

Direct prerequisites: Core, DataGrid, Media, ImageCache. 

## S06

```text
Use Superpowers.

Review execution unit 06: REHLA DASHBOARD FOUNDATION.

Read:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md
docs/superpowers/plans/dashboard-foundation/rehla-dashboard-foundation-implementation.md

Also read relevant specs for:

Core
DataGrid
Media
ImageCache

Inspect their implemented interfaces.

Do not implement.

Dashboard is an Admin presentation/application layer, not a business domain.

Foundation scope should include:

- Dashboard package/provider
- asset build
- Blade layout
- header
- sidebar
- menu rendering
- ACL rendering infrastructure
- RTL/LTR
- dark mode
- responsive shell
- reusable Blade components
- forms
- modal/drawer/dropdown/tabs
- DataGrid UI integration
- Playwright foundation

Do NOT add Catalog/Sales/Payment/Application business screens yet.

Keep Blade + Tailwind + Alpine + Vite.
Do not introduce Vue.

Use brainstorming only for material design conflicts.
```

## E06

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/dashboard-foundation/rehla-dashboard-foundation-implementation.md

Read the master and Dashboard Foundation specs plus direct dependency specs.

All direct dependency Gates must already pass.

Preflight-review the implementation plan.
Use writing-plans and STOP if material changes are required.

Use an isolated worktree.

Implement Dashboard FOUNDATION only.

Use TDD/feature testing for server behavior and Playwright for representative
UI behavior.

Verify:

- Blade/Tailwind/Alpine/Vite
- responsive sidebar
- collapsed sidebar
- RTL Arabic
- LTR English
- dark mode
- menu infrastructure
- ACL-aware rendering
- reusable components
- DataGrid presentation integration
- production frontend build

Do not implement future domain Admin CRUD.

Task review after each task.
Use systematic-debugging for failures.

Run final Feature tests, Playwright baseline, frontend build, architecture
tests and whole-unit code review.

Use verification-before-completion and finishing-a-development-branch.
```

---

# 07 — AdminUsers

## S07

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/admin-users/rehla-admin-users-design.md
docs/superpowers/plans/admin-users/rehla-admin-users-implementation.md

Read Core spec and inspect implemented Core.

Execution unit: REHLA ADMIN USERS.

Do not implement.

Ensure the domain owns:

- AdminUser
- Role
- permission assignments
- dedicated admin guard support
- admin security policy domain
- 2FA domain foundation
- backup-code foundation

AdminUsers depends on Core, NOT Dashboard.

Dashboard may consume AdminUsers later.

Clarify integration with spatie/laravel-permission and Rehla ACL without
duplicating the two concepts.

If spec remains valid, do not modify it.
Material conflicts require brainstorming first.
```

## E07

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/admin-users/rehla-admin-users-implementation.md

Binding specs:

master Rehla spec
admin-users spec
Core spec

Core must be green.

Preflight-check plan against spec.
Correct material plan errors through writing-plans and STOP.

Use isolated worktree and TDD.

Implement only AdminUsers domain and explicitly approved bootstrap integration.

Do not make AdminUsers depend on Dashboard.

Verify:

- admin user model/domain
- roles
- permission assignment
- admin guard integration
- password/security behaviors
- 2FA/backup-code foundations specified by plan
- authorization boundaries

Run package + architecture + security tests.

Review every task and final branch.
Use verification-before-completion.
Finish without automatic merge.
```

---

# 08 — Customers

Dependencies Core + Media. 

## S08

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/customers/rehla-customers-design.md
docs/superpowers/plans/customers/rehla-customers-implementation.md

Read Core and Media designs and inspect their implementations.

Do not implement.

Confirm Customers owns only customer-domain concerns:

- Customer
- profile/contact information
- customer status
- customer authentication domain integration
- customer-owned media references where approved
- repositories/services
- domain events

Admin users do not belong here.
Dashboard presentation does not belong here.

Use brainstorming only for material conflicts.
```

## E08

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/customers/rehla-customers-implementation.md

Required green dependencies:
Core
Media

Read all binding specs.

Review plan before implementation.
If materially inconsistent use writing-plans and STOP.

Use isolated worktree.
Implement only Customers.

Apply TDD to model/domain/service/auth behavior.

Test customer lifecycle, validation, status rules and any Media authorization
integration defined by the spec.

Do not implement API controllers or Dashboard CRUD unless explicitly part of
an approved integration boundary in this plan.

Review tasks individually.

Run package, architecture and relevant integration tests fresh.
Use final review + verification-before-completion.
Finish branch without automatic merge.
```

---

# 09 — Catalog

## S09

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/catalog/rehla-catalog-design.md
docs/superpowers/plans/catalog/rehla-catalog-implementation.md

Dependencies:
Core
Media
ImageCache

Inspect all three implementations.

Do not implement.

Catalog represents Rehla services, not a generic physical-goods Bagisto
catalog.

Verify design ownership of:

- Service/Product representation approved for Rehla
- categories
- pricing representation
- active state
- slug/content
- public catalog media
- repositories/services/contracts

Reject speculative:

- inventory
- shipping
- complex ecommerce product types
- reviews
- wishlist
- unnecessary attributes

Money must not use floating-point arithmetic.

Use brainstorming only if repository reality contradicts approved design.
```

## E09

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/catalog/rehla-catalog-implementation.md

Read master, Catalog and dependency specs.

Core, Media and ImageCache Gates must be green.

Review plan against current interfaces.
If material corrections are required use writing-plans and STOP.

Use isolated worktree and TDD.

Implement only Catalog plus explicitly approved integration.

Ensure:

- server/domain-controlled pricing representation
- safe media relationships
- ImageCache only for eligible public assets
- no physical inventory/shipping complexity
- package boundary remains clean

Run Catalog package tests, Media/ImageCache integration tests where relevant,
architecture tests and static analysis.

Review every task.
Final whole-unit review and verification-before-completion.
Finish branch normally.
```

---

# 10 — CartRule

Dependencies include Core, Rule, Catalog, Customers. 

## S10

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/cart-rule/rehla-cart-rule-design.md
docs/superpowers/plans/cart-rule/rehla-cart-rule-implementation.md

Also read direct dependency specs:

Core
Rule
Catalog
Customers

Inspect their current interfaces.

Do not implement.

Critical dependency rule:

CartRule MUST NOT depend on Checkout.

CartRule must expose its own neutral CartRuleContext.

Verify support for approved V1 concepts:

- rules
- coupons
- percentage/fixed discounts
- minimum subtotal
- service/category restrictions
- validity windows
- priority
- stop further processing
- maximum discount
- usage limits
- customer usage limits
- usage ledger
- concurrency safety

No speculative advanced promotion engine beyond approved scope.

Use brainstorming for material conflicts only.
```

## E10

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/cart-rule/rehla-cart-rule-implementation.md

Required green dependencies:

Core
Rule
Catalog
Customers

Read all relevant specs and review plan consistency.

If the plan introduces Checkout dependency or any other architectural
violation, correct it using writing-plans and STOP.

Use isolated worktree.

Strict TDD required.

Implement CartRule without importing Checkout cart models.

Mandatory tests include:

- percentage discount
- fixed discount
- eligibility
- minimum subtotal
- dates
- priority
- stop-processing
- max discount
- global usage limit
- per-customer usage limit
- simultaneous/concurrent redemption

Use database locking/atomic techniques defined by the approved design.

Review every task.
Systematic-debugging for failures.

Final package + concurrency + architecture tests, final code review and
verification-before-completion.

Finish branch without automatic merge.
```

---

# 11 — Checkout

## S11

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/checkout/rehla-checkout-design.md
docs/superpowers/plans/checkout/rehla-checkout-implementation.md

Read dependency specs:

Core
Customers
Catalog
CartRule

Inspect their actual implementations.

Do not implement.

Verify Checkout owns:

- Cart
- CartItem
- CartManager
- CartValidator
- CheckoutContext
- pricing orchestration
- TotalsPipeline
- TotalCollector
- SubtotalCollector
- DiscountCollector
- GrandTotalCollector
- idempotency
- transactional order-creation boundary

Critical invariants:

- client prices are never authoritative
- no floats for money
- CartRule is consumed through its public contract
- Checkout does not own established Order lifecycle
- duplicate checkout cannot create duplicate order

Use brainstorming only if a real architecture conflict exists.
```

## E11

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/checkout/rehla-checkout-implementation.md

Green prerequisites:

Core
Customers
Catalog
CartRule

Read all specs first.

Review plan against implemented dependency interfaces.
If material mismatch exists, revise through writing-plans and STOP.

Use isolated worktree.

Checkout is high-risk. Use strict TDD.

Mandatory test areas:

- client price tampering
- server-side price recalculation
- invalid cart
- CartRule discounts
- totals ordering
- duplicate idempotency key
- transaction rollback
- immutable checkout/order snapshots as specified
- concurrent/repeated submission

Do not implement Sales lifecycle here.

Review every task carefully.
Use systematic-debugging for failures.

At the Gate run complete Checkout tests, relevant CartRule/Catalog integration,
architecture tests, transaction/idempotency regression suite and static
analysis.

Request final code review.
Use verification-before-completion.

Do not finish until fresh evidence is green.
Then finishing-a-development-branch.
```

---

# 12 — Sales

## S12

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/sales/rehla-sales-design.md
docs/superpowers/plans/sales/rehla-sales-implementation.md

Dependencies:

Core
Customers
Catalog
Checkout

Inspect Checkout's approved order-creation interface.

Do not implement.

Sales owns established orders:

- Order
- OrderItem
- immutable snapshots
- OrderStatus
- OrderStatusHistory
- order lifecycle
- cancellation
- domain events
- approved notes/comments

Maintain the invariant:

OrderStatus != PaymentStatus != ApplicationStatus

Payment and visa processing do not belong here.

If valid preserve the design.
Use brainstorming only when repository evidence reveals a real contradiction.
```

## E12

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/sales/rehla-sales-implementation.md

All direct dependencies must be green.

Read master, Sales, Checkout and other dependency specs.

Preflight-review plan/interface consistency.
Use writing-plans and STOP for material changes.

Use isolated worktree and TDD.

Implement Sales and the approved Checkout order-creation integration.

Test:

- order creation contract
- immutable snapshots
- valid state transitions
- invalid state transitions
- cancellation rules
- status history
- duplicate/invalid transition handling
- domain events

Do not merge Payment or Applications states into Order.

Task reviews mandatory.

Run Sales + Checkout integration + architecture tests.
Final code review.
verification-before-completion.
finishing-a-development-branch.
```

---

# 13 — Payment

## S13

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/payment/rehla-payment-design.md
docs/superpowers/plans/payment/rehla-payment-implementation.md

Dependencies:

Core
Sales
Media

Inspect those implementations.

Do not implement.

Payment should own the approved foundation for:

- Bank
- PaymentMethod
- Payment
- PaymentAttempt
- PaymentStatus
- PaymentStatusHistory
- proof reference
- approve/reject workflow
- payment destination snapshot

Payment proof must use private Media.

PaymentStatus is separate from OrderStatus.

Do not invent an external gateway not present in the approved spec.

Use brainstorming only for material conflicts.
```

## E13

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/payment/rehla-payment-implementation.md

Prerequisites:
Core
Sales
Media

Read all binding specs and preflight-review the plan.

If material mismatch exists use writing-plans and STOP.

Use worktree + strict TDD.

Implement only Payment.

Mandatory tests:

- private payment proof
- payment state transitions
- invalid transitions
- duplicate transitions
- approve/reject authorization domain behavior
- unique references/idempotency where designed
- immutable bank/payment destination snapshot
- independence from OrderStatus

Do not build speculative payment gateways.

Review every task.

Run package + Sales integration + Media security + architecture tests.
Final whole-unit review and verification-before-completion.

Finish branch without automatic merge.
```

---

# 14 — Applications

Dependencies Core, Sales, Customers, Media. 

## S14

```text
Use Superpowers.

Review execution unit 14: REHLA APPLICATIONS.

Read:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/applications/rehla-applications-design.md
docs/superpowers/plans/applications/rehla-applications-implementation.md

Read direct dependency specs:
Core
Sales
Customers
Media

Inspect their implementations.

Do not implement.

Applications is the primary visa-processing domain.

Verify ownership of:

- VisaApplication
- Applicant/traveller
- passport/identity data
- ApplicationDocument
- application status
- status history
- review/processing
- notes
- order/order-item association

Security:

- sensitive documents private
- sensitive fields filtered from logs/audit
- ApplicationStatus independent from OrderStatus and PaymentStatus

Use brainstorming only for material conflicts.
```

## E14

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/applications/rehla-applications-implementation.md

Green prerequisites:

Core
Sales
Customers
Media

Read all specs and critically inspect the implementation plan.

Use writing-plans and STOP if correction is needed.

Use isolated worktree and strict TDD.

Implement Applications only.

Mandatory verification includes:

- application creation/linkage
- applicant ownership
- passport-data handling
- private document authorization
- valid application state transitions
- invalid state transitions
- status history
- no state coupling with Order/Payment
- sensitive-data redaction/logging safety

Review each task.
Use systematic-debugging on any failure.

Run application, Media security, Sales integration and architecture suites.
Request final review and use verification-before-completion.

Finish branch only after fresh evidence.
```

---

# 15 — Notifications

## S15

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/notifications/rehla-notifications-design.md
docs/superpowers/plans/notifications/rehla-notifications-implementation.md

Inspect event contracts exposed by:

Customers
Sales
Payment
Applications

Do not implement.

Notifications should remain a secondary reaction layer:

- queue-first
- event-driven
- channel contracts
- email foundation
- retry/backoff
- delivery status/log
- failure handling
- templates as approved

Do not tightly couple domain packages to mail classes.

Do not move primary transaction logic into event listeners.

Preserve spec unless material repository evidence requires brainstorming.
```

## E15

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/notifications/rehla-notifications-implementation.md

Green prerequisites:

Core
Customers
Sales
Payment
Applications

Review their actual published event interfaces.

Preflight-review plan/spec compatibility.
Use writing-plans and STOP for material corrections.

Use isolated worktree and TDD.

Implement only Notifications and approved event listeners.

Test:

- correct event consumption
- queued delivery
- retry/backoff
- failure state
- delivery status/logging
- no primary business-state mutation by notification listeners
- sensitive data not leaked

Review each task.
Use systematic-debugging on failures.

Final package + event integration + queue tests + architecture checks,
whole-unit review and verification-before-completion.

Finish branch normally.
```

---

# 16 — AuditLog

## S16

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/audit-log/rehla-audit-log-design.md
docs/superpowers/plans/audit-log/rehla-audit-log-implementation.md

Dependencies:
Core
AdminUsers

Inspect their interfaces.

Do not implement.

AuditLog must support approved audit metadata such as:

- actor type/id
- action
- entity type/id
- before/after where safe
- request ID
- IP
- user agent
- timestamps

Never store:

- plaintext passwords
- tokens
- secrets
- document contents
- sensitive passport values
- payment secrets

Check redaction policy and extensibility for future domain event integration.

Use brainstorming for genuine architectural conflicts only.
```

## E16

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/audit-log/rehla-audit-log-implementation.md

Core and AdminUsers must be green.

Read specs and preflight-review plan.

Use writing-plans and STOP if material inconsistency exists.

Use isolated worktree + TDD.

Implement AuditLog and only approved listeners/integration points.

Mandatory tests:

- actor capture
- request/correlation ID
- before/after behavior
- secret redaction
- sensitive field redaction
- admin security action audit
- invalid/unserializable values handled safely

Do not create circular dependencies with business packages.

Run package + architecture + security tests.
Perform whole-unit review.
Use verification-before-completion.

Finish branch without automatic merge.
```

---

# 17 — API V1

## S17

```text
Use Superpowers.

Review:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/api/rehla-api-design.md
docs/superpowers/plans/api/rehla-api-implementation.md

Inspect completed domain interfaces:

Core
Customers
Catalog
Checkout
Sales
Payment
Applications
Media

Do not implement.

API is a Flutter presentation layer.

Confirm:

- /api/v1 versioning
- Sanctum
- Form Requests
- API Resources
- stable error envelope
- pagination contract
- request IDs
- rate limiting
- idempotency where required
- no raw Eloquent responses
- no business logic duplicated in controllers
- private Media authorization
- API documentation strategy

Dashboard controllers must not be reused as API controllers.

Use brainstorming only for material conflicts.
```

## E17

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/api/rehla-api-implementation.md

All direct dependencies listed in the API spec must be green.

Read master, API and relevant domain specs.

Preflight-review the plan against actual domain interfaces.
Correct material mismatch with writing-plans and STOP.

Use isolated worktree and TDD.

Implement API V1 presentation only.

Test:

- authentication
- authorization
- validation
- versioned routes
- JSON error contract
- Resources schemas
- pagination
- rate limiting
- request IDs
- mutation idempotency where relevant
- private document access
- no raw Eloquent serialization

Generate/update API docs as required by plan.

Review every task.

Run API + relevant domain integration + architecture/security tests.
Final code review and verification-before-completion.

Finish branch normally.
```

---

# 18 — Dashboard Integration

هذه المرحلة لا تبدأ قبل Dashboard Foundation وAdminUsers وباقي Domains المحددة في الـmanifest. 

## S18

```text
Use Superpowers.

Review execution unit 18: REHLA DASHBOARD DOMAIN INTEGRATION.

Read:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md
docs/superpowers/specs/dashboard-integration/rehla-dashboard-integration-design.md
docs/superpowers/plans/dashboard-integration/rehla-dashboard-integration-implementation.md

Inspect the completed packages:

Dashboard Foundation
AdminUsers
Customers
Catalog
CartRule
Sales
Payment
Applications
AuditLog

Do not implement.

Dashboard remains presentation/application layer.

It may own:

- Admin controllers
- Admin Requests
- Admin Resources
- Admin DataGrids
- Blade views
- menu.php
- acl.php
- system.php
- reporting presentation
- configuration presentation
- cache-management presentation/service

It must consume Domain services/repositories/contracts.

Do not move domain business logic into Dashboard.

Verify Bagisto-inspired structure without copying Bagisto-specific Vue or
irrelevant ecommerce features.

Use brainstorming only for real design conflicts.
```

## E18

```text
Use superpowers:subagent-driven-development.

Execute:

docs/superpowers/plans/dashboard-integration/rehla-dashboard-integration-implementation.md

All direct prerequisites must already pass their Gates.

Read all binding specs.

Before implementation:
critically compare the Dashboard plan to the actual domain public interfaces.

If integration assumptions are stale, use writing-plans to update the plan and
STOP before changing code.

Use isolated worktree.

Implement Dashboard domain integration only.

Preserve:

Blade + Tailwind + Alpine + Vite

Implement approved Admin presentation for:

- AdminUsers/Roles
- Customers
- Catalog
- CartRules/Coupons
- Sales/Orders
- Payments
- Visa Applications
- Audit visibility/configuration where approved
- reporting/configuration defined by spec

Mandatory properties:

- centralized menu
- centralized ACL
- fail-closed authorization
- domain-specific DataGrids
- no arbitrary DataGrid class route
- no duplicated business logic
- RTL/LTR
- dark mode
- responsive Admin UI

Use Feature tests + representative Playwright E2E.

Review every task.
Systematic-debugging on failures.

Final Gate:

- Dashboard Feature suite
- architecture tests
- ACL/menu/route consistency
- frontend production build
- Playwright
- static analysis
- final whole-unit code review
- verification-before-completion

Finish via finishing-a-development-branch.
```

---

# 19 — Release Hardening

هذه آخر Unit وتعتمد على API + Dashboard Integration + Notifications + AuditLog، عملياً بعد اكتمال جميع الوحدات السابقة. 

## S19

```text
Use Superpowers.

Review final execution unit 19: REHLA RELEASE HARDENING.

Read:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/release-hardening/rehla-release-hardening-design.md
docs/superpowers/plans/release-hardening/rehla-release-hardening-implementation.md

Also read:

docs/superpowers/EXECUTION-ORDER.md
docs/superpowers/manifest.json

Inspect the complete integrated repository.

Do not implement during this review.

Validate that the hardening design covers:

- complete architecture boundary verification
- dependency DAG
- migrations
- Composer validation/audit
- static analysis
- complete Pest suite
- Admin Feature tests
- API contract tests
- Playwright
- frontend production build
- private Media security
- ImageCache traversal/private-media tests
- DataGrid injection/allowlist tests
- CartRule concurrency
- Checkout tampering/idempotency/transactions
- Payment transitions
- Applications sensitive-data protection
- ACL fail-closed behavior
- secret hygiene
- git/repository cleanliness

Do not add new product features during Release Hardening.

Any failure found here is a defect/hardening task, not permission to redesign
the project casually.

If multiple failures occur:
classify their root causes before considering parallel agents.
```

## E19 — Final Execute

```text
Use superpowers:subagent-driven-development.

Execute exactly:

docs/superpowers/plans/release-hardening/rehla-release-hardening-implementation.md

Binding authority:

docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/release-hardening/rehla-release-hardening-design.md
docs/superpowers/manifest.json
docs/superpowers/EXECUTION-ORDER.md

All previous execution units must have passed their completion Gates.

Before modifying anything:

1. Read the hardening plan completely.
2. Check repository status and integration state.
3. Establish a fresh baseline.
4. Verify there are no unfinished unit branches assumed to be integrated.
5. Review plan/spec consistency.
6. Use writing-plans and STOP if the hardening plan needs material revision.
7. Use an isolated worktree.

Do not add new product features.

For every discovered failure:

- use superpowers:systematic-debugging
- establish root cause
- add a failing regression test where applicable
- fix using superpowers:test-driven-development
- verify the focused fix
- review it before continuing

Only use dispatching-parallel-agents after proving failures are truly
independent and do not edit shared files/state.

Final fresh verification must include, as applicable:

php -v
composer --version
composer validate
composer audit
php artisan about
php artisan route:list
php artisan migrate:status
full Pest test suite
architecture test suite
static analysis
frontend production build
Playwright suite
API contract/documentation verification
security regression tests
git diff
git status

Explicitly verify:

- no circular first-party dependencies
- Core remains business-agnostic
- Dashboard and API remain presentation layers
- no arbitrary DataGrid class execution
- no DataGrid unsafe sort/filter identifiers
- no raw-path ImageCache endpoint
- no private Media exposure
- no client-authoritative Checkout pricing
- CartRule usage is concurrency-safe
- Checkout idempotency works
- OrderStatus != PaymentStatus != ApplicationStatus
- admin ACL fails closed
- sensitive values are not logged
- no secrets were committed
- migrations and application boot correctly on PHP 8.5.4 / Laravel 13

Do not claim release readiness based on old test runs.

Use superpowers:verification-before-completion with fresh evidence.

Then request the broad final whole-branch code review using the most capable
available reviewer.

Resolve Critical and Important findings through TDD and re-verification.

Only once the complete release gate is green:

use superpowers:finishing-a-development-branch.

Do not merge or push automatically.
```

---

# التسلسل الذي تستخدمه فعلياً

لا ترسل الـ40 Prompt مرة واحدة. اتبع:

```text
S00 → E00
        ↓
S01 → E01
        ↓
S02 → E02
        ↓
S03 → E03
        ↓
S04 → E04
        ↓
S05 → E05
        ↓
S06 → E06
        ↓
S07 → E07
        ↓
S08 → E08
        ↓
S09 → E09
        ↓
S10 → E10
        ↓
S11 → E11
        ↓
S12 → E12
        ↓
S13 → E13
        ↓
S14 → E14
        ↓
S15 → E15
        ↓
S16 → E16
        ↓
S17 → E17
        ↓
S18 → E18
        ↓
S19 → E19
```

والقاعدة المهمة: **لا ترسل `S01` قبل أن تنتهي `E00` وتختار integration للحزمة الناتجة بحيث تصبح Foundation متاحة كـbase للحزمة التالية.** وثيقة Execution Order تنص صراحةً أن كل Unit لا تبدأ إلا بعد نجاح direct dependencies ووجود base متاح للعمل التالي. 

وعند أي Test/Build failure أثناء أي `E##` لا تكتب Prompt إصلاح عادي؛ استخدم:

```text
Use superpowers:systematic-debugging.

Do not attempt another fix yet.

Reproduce the failure consistently.
Read the complete error and stack trace.
Inspect the relevant recent diff and commits.
Trace the failing data/component boundary.
Compare with the nearest working pattern in this repository.

State one specific root-cause hypothesis and the evidence supporting it.

Test that hypothesis using the smallest diagnostic change possible.

Do not modify production behavior until the root cause is demonstrated.

After root cause is proven:

1. create a failing regression test
2. verify RED for the intended reason
3. use superpowers:test-driven-development
4. implement the minimum root-cause fix
5. verify GREEN
6. run relevant regression tests
7. use superpowers:verification-before-completion before claiming resolution

Do not stack speculative fixes.
```

