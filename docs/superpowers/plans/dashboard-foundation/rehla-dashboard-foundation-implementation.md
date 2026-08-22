# Rehla Dashboard Foundation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` (recommended) or `superpowers:executing-plans` to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build the Bagisto-aligned Rehla admin presentation foundation and design system without prematurely implementing business-domain screens.

**Architecture:** This plan implements one Rehla execution unit only. It consumes already-approved dependencies (core, datagrid, media, image-cache), keeps the package boundary from its design spec, and defers downstream behavior to later plans. Every behavior-bearing task uses TDD and every task ends with fresh verification and a focused commit.

**Tech Stack:** PHP 8.5.4; Composer 2.9.5; Laravel 13.x; PostgreSQL; Pest; Laravel Testbench where package isolation needs it; Blade/Tailwind/Alpine/Vite and Playwright only for Dashboard/frontend units.

**Spec:** `docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md`  
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

1. Read the parent spec and `docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md` completely.
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


### Task 1: Bootstrap Dashboard package and provider

**Files:**
- Create: `packages/Rehla/Dashboard/composer.json`
- Create: `packages/Rehla/Dashboard/src/Providers/DashboardServiceProvider.php`
- Create: `packages/Rehla/Dashboard/src/Providers/EventServiceProvider.php`
- Create: `packages/Rehla/Dashboard/src/Config/menu.php`
- Create: `packages/Rehla/Dashboard/src/Config/acl.php`
- Create: `packages/Rehla/Dashboard/src/Config/system.php`
- Create: `packages/Rehla/Dashboard/tests/Feature/DashboardProviderTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`, `datagrid`, `media`, `image-cache`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Provider loads views/translations/routes/components/config in deterministic way

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/DashboardProviderTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/DashboardProviderTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-foundation): bootstrap dashboard package and provider"
```

Do not include unrelated working-tree changes in the commit.

### Task 2: Build admin layout/header/sidebar and direction foundation

**Files:**
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/layouts/app.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/layouts/header.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/layouts/sidebar.blade.php`
- Create: `packages/Rehla/Dashboard/tests/Feature/AdminLayoutTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`, `datagrid`, `media`, `image-cache`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - RTL derived from locale
  - Sidebar menu derived from Core menu registry
  - No hardcoded business package menu inside layout

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/AdminLayoutTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/AdminLayoutTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-foundation): build admin layout/header/sidebar and direction foundation"
```

Do not include unrelated working-tree changes in the commit.

### Task 3: Build reusable admin component primitives

**Files:**
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/form/group.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/form/input.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/form/textarea.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/form/select.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/form/checkbox.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/form/radio.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/modal.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/drawer.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/datagrid/index.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/datagrid/toolbar.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/datagrid/table.blade.php`
- Create: `packages/Rehla/Dashboard/src/Resources/views/components/datagrid/pagination.blade.php`
- Create: `packages/Rehla/Dashboard/tests/Feature/ComponentRenderTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`, `datagrid`, `media`, `image-cache`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Components render deterministic slots/attributes and support RTL/dark variants

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/ComponentRenderTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/Dashboard/tests/Feature/ComponentRenderTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-foundation): build reusable admin component primitives"
```

Do not include unrelated working-tree changes in the commit.

### Task 4: Configure Dashboard assets with Blade/Tailwind/Alpine/Vite

**Files:**
- Create: `packages/Rehla/Dashboard/package.json`
- Create: `packages/Rehla/Dashboard/vite.config.js`
- Create: `packages/Rehla/Dashboard/src/Resources/assets/css/app.css`
- Create: `packages/Rehla/Dashboard/src/Resources/assets/js/app.js`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`, `datagrid`, `media`, `image-cache`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - No Vue dependency
  - Production assets build to approved admin theme path

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `npm install`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `npm install`
  - Run: `npm run build`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-foundation): configure dashboard assets with blade/tailwind/alpine/vite"
```

Do not include unrelated working-tree changes in the commit.

### Task 5: Add safe admin routing and ACL consistency foundation

**Files:**
- Create: `packages/Rehla/Dashboard/src/Routes/web.php`
- Create: `packages/Rehla/Dashboard/src/Routes/auth-routes.php`
- Create: `packages/Rehla/Dashboard/tests/Feature/AclRouteConsistencyTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`, `datagrid`, `media`, `image-cache`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Public auth allowlist explicit
  - Protected route missing ACL metadata fails test

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
git commit -m "feat(rehla-dashboard-foundation): add safe admin routing and acl consistency foundation"
```

Do not include unrelated working-tree changes in the commit.

### Task 6: Establish Dashboard Playwright baseline

**Files:**
- Create: `packages/Rehla/Dashboard/tests/e2e-pw/layout.spec.ts`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`, `datagrid`, `media`, `image-cache`
- Produces: only interfaces declared in `docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Desktop sidebar
  - collapsed sidebar
  - Arabic RTL
  - English LTR
  - dark mode persistence
  - mobile drawer

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `npx playwright test packages/Rehla/Dashboard/tests/e2e-pw/layout.spec.ts`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `npx playwright test packages/Rehla/Dashboard/tests/e2e-pw/layout.spec.ts`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-dashboard-foundation): establish dashboard playwright baseline"
```

Do not include unrelated working-tree changes in the commit.


## Final Self-Review / Completion Gate

Before the unit is offered for branch integration:

- [ ] Re-read `docs/superpowers/specs/dashboard-foundation/rehla-dashboard-foundation-design.md` and map every requirement to an implemented task/test.
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
