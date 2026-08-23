# Rehla Core Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` (recommended) or `superpowers:executing-plans` to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Provide the business-agnostic kernel consumed by Rehla packages: Menu, ACL, SystemConfig, locale/currency primitives, request correlation and shared application contracts.

**Architecture:** This plan implements one Rehla execution unit only. It consumes already-approved dependencies (foundation), keeps the package boundary from its design spec, and defers downstream behavior to later plans. Every behavior-bearing task uses TDD and every task ends with fresh verification and a focused commit.

**Tech Stack:** PHP 8.5.4; Composer 2.9.5; Laravel 13.x; PostgreSQL; Pest; Laravel Testbench where package isolation needs it; Blade/Tailwind/Alpine/Vite and Playwright only for Dashboard/frontend units.

**Spec:** `docs/superpowers/specs/core/rehla-core-design.md`  
**Parent Spec:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`

> **Path convention amendment (approved 2026-08-23):** Filesystem package paths use lowercase `packages/rehla/*`; PHP namespaces remain PascalCase.

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

1. Read the parent spec and `docs/superpowers/specs/core/rehla-core-design.md` completely.
2. Run `git status --short`, `git branch --show-current`, and `git log --oneline -n 10`.
3. Use `superpowers:using-git-worktrees` to create/verify an isolated workspace; never implement on main/master without explicit approval.
4. Verify `php -v`, `composer --version`, and the current baseline tests.
5. Inspect actual repository paths referenced below. If a referenced path conflicts with an already-approved repository convention, stop execution and amend this plan/spec rather than silently inventing a second convention.
6. Create the SDD progress ledger for this plan when using subagent-driven development.

## File/Responsibility Map

- `packages/rehla/core/composer.json` — package metadata/dependencies/autoload
- `packages/rehla/core/src/Providers/CoreServiceProvider.php` — deterministic package bootstrap
- `packages/rehla/core/tests/` — package-level behavior/security/boundary tests

The Foundation baseline already created the Core package manifest and service provider at these paths. Task 1 extends those files and must not create a second package tree.

## Concrete V1 File Blueprint

The implementation plan uses the following exact V1 target files. Adding another production file requires an explicit responsibility not already represented here; removing one requires a spec amendment.

- `packages/rehla/core/src/Contracts/MenuRegistry.php`
- `packages/rehla/core/src/Contracts/AclRegistry.php`
- `packages/rehla/core/src/Contracts/SystemConfigRepository.php`
- `packages/rehla/core/src/Contracts/CurrentLocale.php`
- `packages/rehla/core/src/Contracts/CurrentCurrency.php`
- `packages/rehla/core/src/Database/Migrations/2026_08_22_010001_create_core_config_table.php`
- `packages/rehla/core/src/Database/Migrations/2026_08_22_010002_create_locales_table.php`
- `packages/rehla/core/src/Database/Migrations/2026_08_22_010003_create_currencies_table.php`
- `packages/rehla/core/src/Models/CoreConfig.php`
- `packages/rehla/core/src/Models/Locale.php`
- `packages/rehla/core/src/Models/Currency.php`
- `packages/rehla/core/src/Menu/MenuManager.php`
- `packages/rehla/core/src/Acl/AclManager.php`
- `packages/rehla/core/src/SystemConfig/SystemConfigManager.php`
- `packages/rehla/core/src/SystemConfig/DatabaseSystemConfigRepository.php`
- `packages/rehla/core/src/Support/RequestId.php`
- `packages/rehla/core/src/Http/Middleware/EnsureRequestId.php`
- `packages/rehla/core/src/Events/SystemConfigChanged.php`

## Task Sequence


### Task 1: Bootstrap Rehla Core package boundary

**Files:**
- Modify: `packages/rehla/core/composer.json`
- Modify: `packages/rehla/core/src/Providers/CoreServiceProvider.php`
- Create: `packages/rehla/core/tests/Feature/PackageBootTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `foundation`
- Produces: only interfaces declared in `docs/superpowers/specs/core/rehla-core-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Package autoloads and boots only approved dependencies: `foundation`
  - Provider loads only package-owned config/routes/migrations/resources needed by this design

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Feature/PackageBootTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Feature/PackageBootTest.php`
  - Run: `composer validate`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-core): bootstrap rehla core package boundary"
```

Do not include unrelated working-tree changes in the commit.

### Task 2: Define public contracts and boundary tests

**Files:**
- Create: `packages/rehla/core/src/Contracts/MenuRegistry.php`
- Create: `packages/rehla/core/src/Contracts/AclRegistry.php`
- Create: `packages/rehla/core/src/Contracts/SystemConfigRepository.php`
- Create: `packages/rehla/core/src/Contracts/CurrentLocale.php`
- Create: `packages/rehla/core/src/Contracts/CurrentCurrency.php`
- Create: `packages/rehla/core/tests/Architecture/BoundaryTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `foundation`
- Produces: only interfaces declared in `docs/superpowers/specs/core/rehla-core-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Public interfaces listed in the design spec are represented by focused contracts/DTOs
  - Forbidden dependencies are rejected by architecture test

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Architecture/BoundaryTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Architecture/BoundaryTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-core): define public contracts and boundary tests"
```

Do not include unrelated working-tree changes in the commit.

### Task 3: Implement package-owned persistence

**Files:**
- Create: `packages/rehla/core/src/Database/Migrations/2026_08_22_010001_create_core_config_table.php`
- Create: `packages/rehla/core/src/Database/Migrations/2026_08_22_010002_create_locales_table.php`
- Create: `packages/rehla/core/src/Database/Migrations/2026_08_22_010003_create_currencies_table.php`
- Create: `packages/rehla/core/src/Models/CoreConfig.php`
- Create: `packages/rehla/core/src/Models/Locale.php`
- Create: `packages/rehla/core/src/Models/Currency.php`
- Create: `packages/rehla/core/tests/Feature/PersistenceTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `foundation`
- Produces: only interfaces declared in `docs/superpowers/specs/core/rehla-core-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Schema enforces package invariants with indexes/unique constraints/foreign keys justified by the design
  - Models hide sensitive fields and money uses the project Money strategy

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Feature/PersistenceTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Feature/PersistenceTest.php`
  - Run: `php artisan migrate:fresh --env=testing --force`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-core): implement package-owned persistence"
```

Do not include unrelated working-tree changes in the commit.

### Task 4: Implement the smallest vertical service path

**Files:**
- Create: `packages/rehla/core/src/Menu/MenuManager.php`
- Create: `packages/rehla/core/src/Acl/AclManager.php`
- Create: `packages/rehla/core/src/SystemConfig/SystemConfigManager.php`
- Create: `packages/rehla/core/src/SystemConfig/DatabaseSystemConfigRepository.php`
- Create: `packages/rehla/core/src/Support/RequestId.php`
- Create: `packages/rehla/core/src/Http/Middleware/EnsureRequestId.php`
- Create: `packages/rehla/core/tests/Feature/PrimaryBehaviorTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `foundation`
- Produces: only interfaces declared in `docs/superpowers/specs/core/rehla-core-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Exercises the primary responsibility: Provide the business-agnostic kernel consumed by Rehla packages: Menu, ACL, SystemConfig, locale/currency primitives, request correlation and shared application contracts.
  - Uses only approved public dependency interfaces and preserves transaction/idempotency rules

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Feature/PrimaryBehaviorTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Feature/PrimaryBehaviorTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-core): implement the smallest vertical service path"
```

Do not include unrelated working-tree changes in the commit.

### Task 5: Implement security invariants as regression tests

**Files:**
- Create: `packages/rehla/core/tests/Feature/SecurityInvariantTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `foundation`
- Produces: only interfaces declared in `docs/superpowers/specs/core/rehla-core-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - ACL fails closed for unknown protected ability
  - secret SystemConfig values are write-only/redacted on read
  - request IDs cannot be supplied as arbitrary trusted audit identity

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Feature/SecurityInvariantTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Feature/SecurityInvariantTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-core): implement security invariants as regression tests"
```

Do not include unrelated working-tree changes in the commit.

### Task 6: Implement typed events and secondary-reaction boundary

**Files:**
- Create: `packages/rehla/core/src/Events/SystemConfigChanged.php`
- Create: `packages/rehla/core/tests/Feature/EventsTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `foundation`
- Produces: only interfaces declared in `docs/superpowers/specs/core/rehla-core-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Events contain stable identifiers/minimal safe payload
  - Core transaction correctness does not depend on an unobservable listener chain

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Feature/EventsTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/rehla/core/tests/Feature/EventsTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-core): implement typed events and secondary-reaction boundary"
```

Do not include unrelated working-tree changes in the commit.

### Task 7: Run Rehla Core completion gate

**Files:**
- Create: `docs/superpowers/evidence/core-gate.md`

**Interfaces:**
- Consumes: approved direct dependency contracts from `foundation`
- Produces: only interfaces declared in `docs/superpowers/specs/core/rehla-core-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Fresh focused package tests pass
  - Relevant architecture/integration tests pass
  - Evidence maps acceptance gate items to command results

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/rehla/core/tests`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/rehla/core/tests`
  - Run: `./vendor/bin/pest tests/Architecture`
  - Run: `git diff --check`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-core): run rehla core completion gate"
```

Do not include unrelated working-tree changes in the commit.


## Final Self-Review / Completion Gate

Before the unit is offered for branch integration:

- [ ] Re-read `docs/superpowers/specs/core/rehla-core-design.md` and map every requirement to an implemented task/test.
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
