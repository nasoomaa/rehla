# Rehla Foundation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` (recommended) or `superpowers:executing-plans` to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Establish the Laravel 13/PHP 8.5 monorepo foundation, deterministic first-party package loading, PostgreSQL/test/frontend conventions, and architecture quality gates before any Rehla domain package is implemented.

**Architecture:** This plan implements one Rehla execution unit only. It consumes already-approved dependencies (repository baseline only), keeps the package boundary from its design spec, and defers downstream behavior to later plans. Every behavior-bearing task uses TDD and every task ends with fresh verification and a focused commit.

**Tech Stack:** PHP 8.5.4; Composer 2.9.5; Laravel 13.x; PostgreSQL; Pest; Laravel Testbench where package isolation needs it; Blade/Tailwind/Alpine/Vite and Playwright only for Dashboard/frontend units.

**Spec:** `docs/superpowers/specs/foundation/rehla-foundation-design.md`  
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

1. Read the parent spec and `docs/superpowers/specs/foundation/rehla-foundation-design.md` completely.
2. Run `git status --short`, `git branch --show-current`, and `git log --oneline -n 10`.
3. Use `superpowers:using-git-worktrees` to create/verify an isolated workspace; never implement on main/master without explicit approval.
4. Verify `php -v`, `composer --version`, and the current baseline tests.
5. Inspect actual repository paths referenced below. If a referenced path conflicts with an already-approved repository convention, stop execution and amend this plan/spec rather than silently inventing a second convention.
6. Create the SDD progress ledger for this plan when using subagent-driven development.

## File/Responsibility Map

- `composer.json` / Laravel bootstrap — application/package integration where this unit requires it
- `tests/Architecture/` — cross-package rules
- `docs/superpowers/evidence/` — fresh gate evidence

## Task Sequence


### Task 1: Capture and protect repository baseline

**Files:**
- Modify: `.gitignore` only if `.worktrees/` is not already ignored
- Create: `tests/Architecture/ArchitectureHarnessTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from None beyond the repository baseline.
- Produces: only interfaces declared in `docs/superpowers/specs/foundation/rehla-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Proves the application/test runner starts from the active PHP 8.5/Laravel 13 environment
  - Proves the architecture-test directory is executable

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `php -v`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `php -v`
  - Run: `composer --version`
  - Run: `composer validate`
  - Run: `./vendor/bin/pest tests/Architecture/ArchitectureHarnessTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-foundation): capture and protect repository baseline"
```

Do not include unrelated working-tree changes in the commit.

### Task 2: Configure first-party Composer monorepo conventions

**Files:**
- Modify: `composer.json`
- Modify: `bootstrap/providers.php` or the existing Laravel 13 provider registry chosen by the repository

**Interfaces:**
- Consumes: approved direct dependency contracts from None beyond the repository baseline.
- Produces: only interfaces declared in `docs/superpowers/specs/foundation/rehla-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Root Composer can resolve `packages/Rehla/*` through deterministic path repositories
  - Provider registration has one explicit deterministic first-party path

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `composer validate`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `composer validate`
  - Run: `composer dump-autoload`
  - Run: `php artisan about`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-foundation): configure first-party composer monorepo conventions"
```

Do not include unrelated working-tree changes in the commit.

### Task 3: Establish package-test and architecture dependency conventions

**Files:**
- Create: `tests/Architecture/PackageDependencyTest.php`
- Create: `tests/Support/RehlaPackageTestCase.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from None beyond the repository baseline.
- Produces: only interfaces declared in `docs/superpowers/specs/foundation/rehla-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Architecture test reads declared package dependencies and can reject a known-invalid fixture/declaration
  - Shared package test base boots Laravel consistently

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest tests/Architecture`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest tests/Architecture`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-foundation): establish package-test and architecture dependency conventions"
```

Do not include unrelated working-tree changes in the commit.

### Task 4: Establish frontend admin build baseline

**Files:**
- Modify/Create: root `package.json` as required by current repository
- Modify/Create: `vite.config.js` as required by current repository
- Modify/Create: Tailwind entry configuration used by the future Dashboard package

**Interfaces:**
- Consumes: approved direct dependency contracts from None beyond the repository baseline.
- Produces: only interfaces declared in `docs/superpowers/specs/foundation/rehla-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Production frontend build succeeds
  - Alpine/Tailwind/Vite versions are compatible with current Laravel 13 toolchain

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
git commit -m "feat(rehla-foundation): establish frontend admin build baseline"
```

Do not include unrelated working-tree changes in the commit.

### Task 5: Establish Playwright baseline

**Files:**
- Create/Modify: `playwright.config.ts`
- Create: `tests/e2e/smoke.spec.ts`

**Interfaces:**
- Consumes: approved direct dependency contracts from None beyond the repository baseline.
- Produces: only interfaces declared in `docs/superpowers/specs/foundation/rehla-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Browser runner can open the test application and assert a stable response without requiring future Dashboard screens

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `npx playwright test tests/e2e/smoke.spec.ts`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `npx playwright test tests/e2e/smoke.spec.ts`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-foundation): establish playwright baseline"
```

Do not include unrelated working-tree changes in the commit.

### Task 6: Run Foundation gate and document evidence

**Files:**
- Create: `docs/superpowers/evidence/foundation-gate.md`

**Interfaces:**
- Consumes: approved direct dependency contracts from None beyond the repository baseline.
- Produces: only interfaces declared in `docs/superpowers/specs/foundation/rehla-foundation-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Records fresh command output summary, versions, pass/fail counts, and any explicit non-blocking limitations

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `composer validate`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `composer validate`
  - Run: `php artisan test`
  - Run: `npm run build`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-foundation): run foundation gate and document evidence"
```

Do not include unrelated working-tree changes in the commit.


## Final Self-Review / Completion Gate

Before the unit is offered for branch integration:

- [ ] Re-read `docs/superpowers/specs/foundation/rehla-foundation-design.md` and map every requirement to an implemented task/test.
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
