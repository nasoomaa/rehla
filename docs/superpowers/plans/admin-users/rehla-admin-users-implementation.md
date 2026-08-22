# Rehla AdminUsers Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` (recommended) or `superpowers:executing-plans` to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Own administrator identities, roles, permission assignment, dedicated admin authentication support, 2FA and backup-code domain behavior.

**Architecture:** This plan implements one Rehla execution unit only. It consumes already-approved dependencies (core), keeps the package boundary from its design spec, and defers downstream behavior to later plans. Every behavior-bearing task uses TDD and every task ends with fresh verification and a focused commit.

**Tech Stack:** PHP 8.5.4; Composer 2.9.5; Laravel 13.x; PostgreSQL; Pest; Laravel Testbench where package isolation needs it; Blade/Tailwind/Alpine/Vite and Playwright only for Dashboard/frontend units.

**Spec:** `docs/superpowers/specs/admin-users/rehla-admin-users-design.md`  
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

1. Read the parent spec and `docs/superpowers/specs/admin-users/rehla-admin-users-design.md` completely.
2. Run `git status --short`, `git branch --show-current`, and `git log --oneline -n 10`.
3. Use `superpowers:using-git-worktrees` to create/verify an isolated workspace; never implement on main/master without explicit approval.
4. Verify `php -v`, `composer --version`, and the current baseline tests.
5. Inspect actual repository paths referenced below. If a referenced path conflicts with an already-approved repository convention, stop execution and amend this plan/spec rather than silently inventing a second convention.
6. Create the SDD progress ledger for this plan when using subagent-driven development.

## File/Responsibility Map

- `packages/Rehla/AdminUsers/composer.json` — package metadata/dependencies/autoload
- `packages/Rehla/AdminUsers/src/Providers/AdminUsersServiceProvider.php` — deterministic package bootstrap
- `packages/Rehla/AdminUsers/tests/` — package-level behavior/security/boundary tests

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

## Task Sequence


### Task 1: Bootstrap Rehla AdminUsers package boundary

**Files:**
- Create: `packages/Rehla/AdminUsers/composer.json`
- Create: `packages/Rehla/AdminUsers/src/Providers/AdminUsersServiceProvider.php`
- Create: `packages/Rehla/AdminUsers/tests/Feature/PackageBootTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`
- Produces: only interfaces declared in `docs/superpowers/specs/admin-users/rehla-admin-users-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Package autoloads and boots only approved dependencies: `core`
  - Provider loads only package-owned config/routes/migrations/resources needed by this design

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/PackageBootTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/PackageBootTest.php`
  - Run: `composer validate`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-admin-users): bootstrap rehla adminusers package boundary"
```

Do not include unrelated working-tree changes in the commit.

### Task 2: Define public contracts and boundary tests

**Files:**
- Create: `packages/Rehla/AdminUsers/src/Contracts/AdminUserRepository.php`
- Create: `packages/Rehla/AdminUsers/src/Contracts/AdminAuthenticator.php`
- Create: `packages/Rehla/AdminUsers/src/Contracts/TwoFactorManager.php`
- Create: `packages/Rehla/AdminUsers/src/Contracts/RoleAssignment.php`
- Create: `packages/Rehla/AdminUsers/tests/Architecture/BoundaryTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`
- Produces: only interfaces declared in `docs/superpowers/specs/admin-users/rehla-admin-users-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Public interfaces listed in the design spec are represented by focused contracts/DTOs
  - Forbidden dependencies are rejected by architecture test

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Architecture/BoundaryTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Architecture/BoundaryTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-admin-users): define public contracts and boundary tests"
```

Do not include unrelated working-tree changes in the commit.

### Task 3: Implement package-owned persistence

**Files:**
- Create: `packages/Rehla/AdminUsers/src/Database/Migrations/2026_08_22_070001_create_admin_users_table.php`
- Create: `packages/Rehla/AdminUsers/src/Database/Migrations/2026_08_22_070002_add_two_factor_columns_to_admin_users_table.php`
- Create: `packages/Rehla/AdminUsers/src/Database/Migrations/2026_08_22_070003_create_permission_tables.php`
- Create: `packages/Rehla/AdminUsers/src/Models/AdminUser.php`
- Create: `packages/Rehla/AdminUsers/tests/Feature/PersistenceTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`
- Produces: only interfaces declared in `docs/superpowers/specs/admin-users/rehla-admin-users-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Schema enforces package invariants with indexes/unique constraints/foreign keys justified by the design
  - Models hide sensitive fields and money uses the project Money strategy

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/PersistenceTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/PersistenceTest.php`
  - Run: `php artisan migrate:fresh --env=testing --force`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-admin-users): implement package-owned persistence"
```

Do not include unrelated working-tree changes in the commit.

### Task 4: Implement the smallest vertical service path

**Files:**
- Create: `packages/Rehla/AdminUsers/src/Repositories/EloquentAdminUserRepository.php`
- Create: `packages/Rehla/AdminUsers/src/Services/AdminAuthenticationService.php`
- Create: `packages/Rehla/AdminUsers/src/Services/TwoFactorService.php`
- Create: `packages/Rehla/AdminUsers/src/Services/RoleAssignmentService.php`
- Create: `packages/Rehla/AdminUsers/tests/Feature/PrimaryBehaviorTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`
- Produces: only interfaces declared in `docs/superpowers/specs/admin-users/rehla-admin-users-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Exercises the primary responsibility: Own administrator identities, roles, permission assignment, dedicated admin authentication support, 2FA and backup-code domain behavior.
  - Uses only approved public dependency interfaces and preserves transaction/idempotency rules

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/PrimaryBehaviorTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/PrimaryBehaviorTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-admin-users): implement the smallest vertical service path"
```

Do not include unrelated working-tree changes in the commit.

### Task 5: Implement security invariants as regression tests

**Files:**
- Create: `packages/Rehla/AdminUsers/tests/Feature/SecurityInvariantTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`
- Produces: only interfaces declared in `docs/superpowers/specs/admin-users/rehla-admin-users-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Dedicated admin guard
  - password hashing
  - session regeneration
  - login throttling
  - 2FA secret encryption
  - backup code hashing
  - role changes audited later

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/SecurityInvariantTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/SecurityInvariantTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-admin-users): implement security invariants as regression tests"
```

Do not include unrelated working-tree changes in the commit.

### Task 6: Implement typed events and secondary-reaction boundary

**Files:**
- Create: `packages/Rehla/AdminUsers/src/Events/AdminUserCreated.php`
- Create: `packages/Rehla/AdminUsers/src/Events/AdminRoleChanged.php`
- Create: `packages/Rehla/AdminUsers/src/Events/AdminTwoFactorChanged.php`
- Create: `packages/Rehla/AdminUsers/tests/Feature/EventsTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`
- Produces: only interfaces declared in `docs/superpowers/specs/admin-users/rehla-admin-users-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Events contain stable identifiers/minimal safe payload
  - Core transaction correctness does not depend on an unobservable listener chain

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/EventsTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/EventsTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-admin-users): implement typed events and secondary-reaction boundary"
```

Do not include unrelated working-tree changes in the commit.

### Task 7: Integrate admin authentication and 2FA presentation boundary

**Files:**
- Create: `packages/Rehla/AdminUsers/src/Services/AdminAuthenticationService.php`
- Create: `packages/Rehla/AdminUsers/tests/Feature/AdminAuthenticationTest.php`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`
- Produces: only interfaces declared in `docs/superpowers/specs/admin-users/rehla-admin-users-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Dedicated admin guard authenticates only admins
  - 2FA and backup codes follow security design

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/AdminAuthenticationTest.php`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests/Feature/AdminAuthenticationTest.php`

  Expected after implementation: exit code 0 for the applicable focused commands and no new warnings treated as project failures.

- [ ] **Step 5: Refactor while green**

  Remove duplication, improve naming and tighten package boundaries without adding behavior. Re-run the focused test after refactor.

- [ ] **Step 6: Commit the task**

```bash
git status --short
git diff --check
git add -p
git commit -m "feat(rehla-admin-users): integrate admin authentication and 2fa presentation boundary"
```

Do not include unrelated working-tree changes in the commit.

### Task 8: Run Rehla AdminUsers completion gate

**Files:**
- Create: `docs/superpowers/evidence/admin-users-gate.md`

**Interfaces:**
- Consumes: approved direct dependency contracts from `core`
- Produces: only interfaces declared in `docs/superpowers/specs/admin-users/rehla-admin-users-design.md` for this task's responsibility.

- [ ] **Step 1: Write the failing test or executable gate first**

  Required behavior:
  - Fresh focused package tests pass
  - Relevant architecture/integration tests pass
  - Evidence maps acceptance gate items to command results

  For behavior-bearing PHP work, create the smallest Pest test that fails because the required production behavior is absent. For configuration/generated metadata, use the first executable validation command as the red gate.

- [ ] **Step 2: Run the focused RED/gate command**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests`

  Expected before implementation: the new behavior test fails for the intended missing behavior, or the validation gate identifies the not-yet-configured requirement.

- [ ] **Step 3: Implement the minimum approved behavior**

  Implement only the code/configuration required to satisfy the behavior above. Do not implement responsibilities from later tasks or packages.

- [ ] **Step 4: Run focused GREEN verification**
  - Run: `./vendor/bin/pest packages/Rehla/AdminUsers/tests`
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
git commit -m "feat(rehla-admin-users): run rehla adminusers completion gate"
```

Do not include unrelated working-tree changes in the commit.


## Final Self-Review / Completion Gate

Before the unit is offered for branch integration:

- [ ] Re-read `docs/superpowers/specs/admin-users/rehla-admin-users-design.md` and map every requirement to an implemented task/test.
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
