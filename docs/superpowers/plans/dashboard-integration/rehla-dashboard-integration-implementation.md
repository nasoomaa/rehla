# Rehla Dashboard Domain Integration Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` (recommended) or `superpowers:executing-plans` to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Complete the Bagisto-aligned Admin application by adding domain controllers, requests, DataGrids, views, configuration, reporting foundation and ACL/menu coverage over already-implemented domain services.

**Architecture:** This plan implements one Rehla execution unit only. It consumes already-approved dependencies (dashboard-foundation, admin-users, customers, catalog, cart-rule, sales, payment, applications, audit-log), keeps the package boundary from its design spec, and defers downstream behavior to later plans. Every behavior-bearing task uses TDD and every task ends with fresh verification and a focused commit.

**Tech Stack:** PHP 8.5.4; Composer 2.9.5; Laravel 13.x; PostgreSQL; Pest; Laravel Testbench where package isolation needs it; Blade/Tailwind/Alpine/Vite and Playwright only for Dashboard/frontend units.

**Spec:** `docs/superpowers/specs/dashboard-integration/rehla-dashboard-integration-design.md`  
**Parent Spec:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`

## Global Constraints

- PHP runtime target is exactly the active PHP 8.5.4 environment; do not downgrade it.
- Laravel target is 13.x and dependencies must be verified compatible before installation.
- PostgreSQL is the database target.
- First-party package dependencies must remain acyclic.
- `Core` remains business-agnostic.
- Dashboard/API are presentation layers and may not absorb domain business logic.
- Money never uses binary floating point.
- Private passport/identity/visa/payment-proof media must never become public ImageCache content.
- Admin authorization fails closed.
- Do not print secret environment values; inspect presence/names or redact values.
- Do not implement another execution unit merely because its future interface is convenient.
- Fresh verification evidence is required before task/package completion claims.

---

## Preflight — required before Task 1

1. Read the parent spec and `docs/superpowers/specs/dashboard-integration/rehla-dashboard-integration-design.md` completely.
2. Run `git status --short`, `git branch --show-current`, and `git log --oneline -n 10`.
3. Use `superpowers:using-git-worktrees` to create/verify an isolated workspace; never implement on main/master without explicit approval.
4. Verify `php -v`, `composer --version`, and the current baseline tests.
5. Inspect actual repository paths referenced below. If a referenced path conflicts with an already-approved repository convention, stop execution and amend this plan/spec rather than silently inventing a second convention.
6. Create the SDD progress ledger for this plan when using subagent-driven development.

## File/Responsibility Map

- `packages/Rehla/Dashboard/composer.json` — package metadata/dependencies/autoload
- `packages/Rehla/Dashboard/src/Providers/DashboardServiceProvider.php` — deterministic package bootstrap
- `packages/Rehla/Dashboard/tests/` — package-level behavior/security/boundary tests

## Task Sequence


### Task 1: Lock central menu/ACL route map

**Files:**
- Modify: `packages/Rehla/Dashboard/src/Config/menu.php`
- Modify: `packages/Rehla/Dashboard/src/Config/acl.php`
- Create: `packages/Rehla/Dashboard/tests/Feature/AclRouteConsistencyTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `dashboard-foundation`, `admin-users`, `customers`, `catalog`, `cart-rule`, `sales`, `payment`, `applications`, `audit-log`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-integration/rehla-dashboard-integration-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Every protected admin route ID planned for domain integration maps to one valid ACL key
  - Every menu ACL key exists

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/AclRouteConsistencyTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/AclRouteConsistencyTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-integration): lock central menu/acl route map"
```

Do not include unrelated working-tree changes in the commit.

### Task 2: Integrate Catalog and Customers admin presentation

**Files:**
- Create: `packages/Rehla/Dashboard/src/Http/Controllers/Catalog/ServiceController.php`
- Create: `packages/Rehla/Dashboard/src/Http/Controllers/Customers/CustomerController.php`
- Create: `packages/Rehla/Dashboard/src/DataGrids/Catalog/ServiceDataGrid.php`
- Create: `packages/Rehla/Dashboard/src/DataGrids/Customers/CustomerDataGrid.php`
- Create: `packages/Rehla/Dashboard/tests/Feature/Catalog/ServiceAdminTest.php`
- Create: `packages/Rehla/Dashboard/tests/Feature/Customers/CustomerAdminTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `dashboard-foundation`, `admin-users`, `customers`, `catalog`, `cart-rule`, `sales`, `payment`, `applications`, `audit-log`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-integration/rehla-dashboard-integration-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Controllers consume domain services/repositories; no business rules copied into Dashboard
  - DataGrids use registered fields/actions

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/Catalog packages/Rehla/Dashboard/tests/Feature/Customers`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/Catalog packages/Rehla/Dashboard/tests/Feature/Customers`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-integration): integrate catalog and customers admin presentation"
```

Do not include unrelated working-tree changes in the commit.

### Task 3: Integrate Sales, Payment and Applications presentation

**Files:**
- Create: `packages/Rehla/Dashboard/src/Http/Controllers/Sales/OrderController.php`
- Create: `packages/Rehla/Dashboard/src/Http/Controllers/Payments/PaymentController.php`
- Create: `packages/Rehla/Dashboard/src/Http/Controllers/Applications/ApplicationController.php`
- Create: `packages/Rehla/Dashboard/src/DataGrids/Sales/OrderDataGrid.php`
- Create: `packages/Rehla/Dashboard/src/DataGrids/Payments/PaymentDataGrid.php`
- Create: `packages/Rehla/Dashboard/src/DataGrids/Applications/ApplicationDataGrid.php`
- Create: `packages/Rehla/Dashboard/tests/Feature/DomainAdminFlowsTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `dashboard-foundation`, `admin-users`, `customers`, `catalog`, `cart-rule`, `sales`, `payment`, `applications`, `audit-log`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-integration/rehla-dashboard-integration-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - State-changing actions delegate to owning domain services
  - Order/Payment/Application statuses remain presented separately

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/DomainAdminFlowsTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/DomainAdminFlowsTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-integration): integrate sales, payment and applications presentation"
```

Do not include unrelated working-tree changes in the commit.

### Task 4: Integrate CartRule promotions admin

**Files:**
- Create: `packages/Rehla/Dashboard/src/Http/Controllers/Marketing/CartRuleController.php`
- Create: `packages/Rehla/Dashboard/src/DataGrids/Marketing/CartRuleDataGrid.php`
- Create: `packages/Rehla/Dashboard/tests/Feature/Marketing/CartRuleAdminTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `dashboard-foundation`, `admin-users`, `customers`, `catalog`, `cart-rule`, `sales`, `payment`, `applications`, `audit-log`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-integration/rehla-dashboard-integration-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - CRUD/evaluation configuration delegates to CartRule package
  - No Checkout model dependency introduced into CartRule

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/Marketing/CartRuleAdminTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/Marketing/CartRuleAdminTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-integration): integrate cartrule promotions admin"
```

Do not include unrelated working-tree changes in the commit.

### Task 5: Complete SystemConfig, cache management and reporting presentation

**Files:**
- Create/Modify: `packages/Rehla/Dashboard/src/Http/Controllers/Configuration/ConfigurationController.php`
- Create/Modify: `packages/Rehla/Dashboard/src/Services/CacheManagerService.php`
- Create: `packages/Rehla/Dashboard/src/Http/Controllers/Reporting/ReportingController.php`
- Create: `packages/Rehla/Dashboard/tests/Feature/ConfigurationTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `dashboard-foundation`, `admin-users`, `customers`, `catalog`, `cart-rule`, `sales`, `payment`, `applications`, `audit-log`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-integration/rehla-dashboard-integration-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - SystemConfig UI edits Core engine values
  - Cache commands come only from allowlist
  - Reporting is read-only presentation/query composition

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/ConfigurationTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/ConfigurationTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-integration): complete systemconfig, cache management and reporting presentation"
```

Do not include unrelated working-tree changes in the commit.

### Task 6: Run Dashboard integration E2E gate

**Files:**
- Create/Modify: `packages/Rehla/Dashboard/tests/e2e-pw/domain-flows.spec.ts`

**Interfaces:**
- Consumes: approved direct dependency contracts from `dashboard-foundation`, `admin-users`, `customers`, `catalog`, `cart-rule`, `sales`, `payment`, `applications`, `audit-log`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-integration/rehla-dashboard-integration-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Representative Catalog, Customer, Order, Payment, Application navigation and ACL-denial flows pass in both required locale directions

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `npm run build`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `npm run build`
  - Run: `npx playwright test packages/Rehla/Dashboard/tests/e2e-pw`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-integration): run dashboard integration e2e gate"
```

Do not include unrelated working-tree changes in the commit.


## Final Self-Review / Completion Gate

Before the unit is offered for branch integration:

- [ ] Re-read `docs/superpowers/specs/dashboard-integration/rehla-dashboard-integration-design.md` and map every requirement to an implemented task/test.
- [ ] Search this plan and produced code for placeholder behavior (`TODO`, `TBD`, empty service methods) and remove any implementation placeholders introduced by this unit.
- [ ] Run the complete focused package/unit suite fresh.
- [ ] Run relevant `tests/Architecture` fresh.
- [ ] Run `composer validate` if Composer files changed.
- [ ] Run migration checks if this unit owns persistence.
- [ ] Run `npm run build` and relevant Playwright tests if frontend/Admin assets changed.
- [ ] Run `git diff --check` and inspect `git status --short`.
- [ ] Use `superpowers:requesting-code-review` for a whole-unit review.
- [ ] Resolve Critical and Important findings using `superpowers:receiving-code-review` discipline.
- [ ] Use `superpowers:verification-before-completion` before stating the unit is complete.
- [ ] Use `superpowers:finishing-a-development-branch`; do not merge/push/delete the worktree without the user's integration choice.
