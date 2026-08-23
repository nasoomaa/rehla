# Rehla Foundation Completion Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` (recommended) or `superpowers:executing-plans` to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Complete and harden the existing Laravel 13/PHP 8.5 M0 baseline with executable monorepo contracts, PostgreSQL-safe test conventions, shared package testing, static analysis/formatting, a warning-free Alpine/Tailwind/Vite entrypoint, Playwright smoke coverage, and fresh Foundation evidence.

**Architecture:** Commit `5055922` already contains the Laravel skeleton, all 17 first-party package stubs, explicit path repositories, provider order, a partial architecture suite, and initial CI. Preserve that baseline and add only missing Foundation responsibilities at repository/application-infrastructure level. Architecture and safety rules are executable test-support contracts; no Core, DataGrid, Dashboard, API, or domain behavior is implemented.

**Tech Stack:** PHP 8.5.4; Composer 2.9.5; Laravel 13.x; PostgreSQL; Pest 4; Orchestra Testbench 11; Larastan 3.10; Pint; Node 24; Vite 8; Tailwind CSS 4; Alpine.js 3.16; Playwright 1.62.

**Spec:** `docs/superpowers/specs/foundation/rehla-foundation-design.md`  
**Parent Spec:** `docs/superpowers/specs/2026-08-22-rehla-platform-design.md`

## Global Constraints

- PHP runtime target is exactly PHP 8.5.4; do not downgrade it.
- Laravel target is 13.x; dependency changes must be verified compatible with PHP 8.5.4 and Laravel 13 before installation.
- PostgreSQL is the application and test database target; SQLite is not an accepted Foundation test substitute.
- Test database names must end in `_testing`; destructive test database helpers must fail before touching any other database.
- Canonical first-party paths are lowercase `packages/rehla/*`, matching the parent spec and committed M0 convention.
- First-party Composer dependencies and provider order must remain deterministic and acyclic.
- `Core` remains business-agnostic; domain packages must not depend on Dashboard or API.
- Dashboard/API remain presentation layers; this unit creates no Dashboard screen, API endpoint, domain model, migration, or business service.
- Money never uses binary floating point.
- Private passport/identity/visa/payment-proof media must never become public ImageCache content.
- Admin authorization fails closed.
- Never print secret environment values; inspect only names/presence or redact values.
- Generated/configuration changes still require an executable failing gate; do not use a command that already passes as a claimed RED.
- Every behavior change follows RED → verify RED → GREEN → verify GREEN → REFACTOR → verify → task review → commit.
- Fresh verification evidence is required before task and Foundation completion claims.

---

## Preflight — required before Task 1

1. Read both binding specs and this complete plan.
2. Run `git status --short`, `git branch --show-current`, and `git log --oneline -n 10`.
3. Respect the user's explicit instruction to execute on `main`; preserve all pre-existing working-tree changes and stage only exact task pathspecs.
4. Run `php -v`, `composer --version`, `node --version`, and `npm --version` without printing environment values.
5. Install lockfile dependencies if absent: `composer install --no-interaction --prefer-dist` and `npm install`.
6. Run the unchanged baseline: `composer validate`, `./vendor/bin/pest`, `php artisan about --only=environment`, and `npm run build`. Record warnings as work to resolve; do not call a warning-producing gate pristine.
7. Initialize/resume this plan's SDD ledger with `scripts/sdd-workspace` and resume only the first task lacking `Task <N>: complete`.

## Existing Baseline — preserve, test, do not recreate

- Laravel 13 application skeleton and `/up` health route.
- Seventeen lowercase `packages/rehla/*` Composer packages and provider stubs.
- Root path repositories and explicit provider order in `bootstrap/providers.php`.
- Pest/Orchestra dependencies and registered `tests/Architecture` suite.
- Initial package-boundary tests and GitHub Actions PostgreSQL service.
- Root Tailwind 4/Vite 8 build scaffold.

## Plan-Specific SDD Review/Commit Order

The user's binding order overrides the stock SDD template for this plan: task review occurs before commit.

1. The implementer performs RED, verified RED, minimum GREEN, verified GREEN, refactor, and final focused verification, but does not commit.
2. The controller writes a review package containing the stat and unified diff restricted to the paths listed in that task's Files block; user-owned paths are excluded.
3. A fresh task reviewer returns both spec-compliance and code-quality verdicts.
4. Fix rounds remain uncommitted and use path-filtered diffs from the prior reviewed file state.
5. Only after the task review is clean does the original implementer stage the exact task paths, commit with the specified message, append its report, and return the commit SHA.
6. The controller verifies the commit diff and records `Task <N>: complete` in the ledger before dispatching the next task.

## File/Responsibility Map

- `tests/Support/Architecture/PackageDependencyGraph.php` — test-only manifest graph parser and validator.
- `tests/Architecture/PackageDependencyTest.php` — exact direct-dependency and cycle contract.
- `tests/Support/Architecture/MonorepoConfiguration.php` — test-only root repository/provider validator.
- `tests/Architecture/MonorepoConfigurationTest.php` — deterministic path/provider contract.
- `.env.example`, `.env.testing.example`, `phpunit.xml`, `.github/workflows/ci.yml` — PostgreSQL and secret-safe environment conventions.
- `tests/Support/TestDatabaseGuard.php` — fail-closed protection for test database configuration.
- `tests/TestCase.php`, `tests/Support/RehlaPackageTestCase.php` — application/package test boot conventions.
- `phpstan.neon`, `composer.json`, `composer.lock` — Larastan/Pint gates.
- `package.json`, `package-lock.json`, `resources/js/app.js`, `vite.config.js` — Alpine/Tailwind/Vite baseline.
- `playwright.config.ts`, `tests/e2e/*`, `routes/web.php`, `resources/views/foundation-smoke.blade.php` — testing-only browser smoke surface.
- `docs/superpowers/evidence/foundation-gate.md` — redacted summaries of fresh final commands.

## Task Sequence

### Task 1: Enforce the complete first-party dependency DAG

**Files:**
- Modify: `tests/Architecture/DependencyTest.php`
- Create: `tests/Support/Architecture/PackageDependencyGraph.php`
- Create: `tests/Architecture/PackageDependencyTest.php`

**Interfaces:**
- Consumes: each `packages/rehla/*/composer.json` `name` and `require` map.
- Produces: `Tests\Support\Architecture\PackageDependencyGraph::violations(string $packagesRoot, array $expected): array<int,string>`.

- [ ] **Step 1: Write the failing graph tests**

  Create a temporary two-package fixture whose requirements form `core → catalog → core`; expect the literal cycle `circular dependency: rehla/catalog -> rehla/core -> rehla/catalog`. Test the real manifests against this exact approved map and expect `[]`:

  ```php
  $expected = [
      'rehla/core' => [],
      'rehla/datagrid' => ['rehla/core'],
      'rehla/rule' => ['rehla/core'],
      'rehla/media' => ['rehla/core'],
      'rehla/image-cache' => ['rehla/core', 'rehla/media'],
      'rehla/customers' => ['rehla/core'],
      'rehla/admin-users' => ['rehla/core'],
      'rehla/catalog' => ['rehla/core'],
      'rehla/cart-rule' => ['rehla/core', 'rehla/rule', 'rehla/catalog', 'rehla/customers'],
      'rehla/sales' => ['rehla/core', 'rehla/catalog', 'rehla/customers'],
      'rehla/payment' => ['rehla/core', 'rehla/sales', 'rehla/media'],
      'rehla/checkout' => ['rehla/core', 'rehla/catalog', 'rehla/customers', 'rehla/cart-rule', 'rehla/sales', 'rehla/payment'],
      'rehla/applications' => ['rehla/core', 'rehla/sales', 'rehla/customers', 'rehla/media'],
      'rehla/notifications' => ['rehla/core'],
      'rehla/audit-log' => ['rehla/core'],
      'rehla/dashboard' => ['rehla/core', 'rehla/datagrid', 'rehla/catalog', 'rehla/customers', 'rehla/admin-users', 'rehla/cart-rule', 'rehla/sales', 'rehla/payment', 'rehla/checkout', 'rehla/applications', 'rehla/media', 'rehla/image-cache', 'rehla/audit-log'],
      'rehla/api' => ['rehla/core', 'rehla/catalog', 'rehla/customers', 'rehla/cart-rule', 'rehla/checkout', 'rehla/sales', 'rehla/payment', 'rehla/applications'],
  ];
  ```

- [ ] **Step 2: Verify RED**

  Run: `./vendor/bin/pest tests/Architecture/PackageDependencyTest.php`

  Expected: if the missing helper errors, add only its signature returning `[]`, rerun, and verify a normal assertion failure because the invalid cycle is accepted.

- [ ] **Step 3: Implement minimum GREEN**

  Implement `violations()` to discover immediate child manifests, collect only `rehla/*` requirements, report missing/unexpected packages and exact direct-dependency differences, and use deterministic depth-first traversal with `visiting`/`visited` sets to report cycles. Return sorted unique messages. Preserve the existing Core/Catalog source-boundary assertions in `DependencyTest.php` and extend them so all non-presentation package namespaces are forbidden from using `Rehla\Dashboard` or `Rehla\Api`. Do not add package runtime code.

- [ ] **Step 4: Verify GREEN**

  Run: `./vendor/bin/pest tests/Architecture/PackageDependencyTest.php`

  Expected: the malicious fixture is rejected and the real graph matches the approved map.

- [ ] **Step 5: REFACTOR and verify**

  Extract manifest decoding/DFS only if it removes duplication. Run the focused test and then `./vendor/bin/pest tests/Architecture`.

- [ ] **Step 6: Task review and commit**

  ```bash
  git diff --check
  git add tests/Architecture/DependencyTest.php tests/Architecture/PackageDependencyTest.php tests/Support/Architecture/PackageDependencyGraph.php
  git commit -m "test(rehla-foundation): enforce package dependency graph"
  ```

### Task 2: Protect deterministic Composer paths and provider order

**Files:**
- Modify: `composer.json`
- Modify: `composer.lock`
- Create: `tests/Support/Architecture/MonorepoConfiguration.php`
- Create: `tests/Architecture/MonorepoConfigurationTest.php`

**Interfaces:**
- Consumes: decoded root `composer.json`; returned array from `bootstrap/providers.php`.
- Produces: `Tests\Support\Architecture\MonorepoConfiguration::violations(array $composer, array $providers): array<int,string>`.

- [ ] **Step 1: Write failing configuration-contract tests**

  Test a literal invalid fixture containing a missing package path, duplicated path, unbound first-party version `*@dev`, and reversed Core/Catalog providers. Expect one literal violation for each break. Test real files and expect no violations.

- [ ] **Step 2: Verify RED**

  Run: `./vendor/bin/pest tests/Architecture/MonorepoConfigurationTest.php`

  Expected: after adding only a compile-safe `violations(): array { return []; }` shell if needed, the invalid fixture fails because it returns no violations.

- [ ] **Step 3: Implement minimum GREEN**

  Require one unique path repository and root requirement for every real `packages/rehla/*` directory, no path outside that lowercase root, explicit first-party constraint `dev-main`, and the exact section-35 provider sequence preceded only by `App\Providers\AppServiceProvider`. Change root first-party constraints from `*@dev` to `dev-main`; preserve package manifests and already-correct repository/provider lists.

- [ ] **Step 4: Verify GREEN**

  ```bash
  composer update 'rehla/*' --with-dependencies --no-interaction
  composer validate --strict
  composer dump-autoload
  php artisan about --only=environment
  ./vendor/bin/pest tests/Architecture/MonorepoConfigurationTest.php
  ```

  Expected: exit 0, no unbound first-party warnings, and Laravel boots.

- [ ] **Step 5: REFACTOR and verify**

  Keep expected literals in the test, not configuration code. Re-run Task 1 and Task 2 tests.

- [ ] **Step 6: Task review and commit**

  ```bash
  git diff --check
  git add composer.json composer.lock tests/Architecture/MonorepoConfigurationTest.php tests/Support/Architecture/MonorepoConfiguration.php
  git commit -m "test(rehla-foundation): protect monorepo loading order"
  ```

### Task 3: Enforce PostgreSQL-only safe test conventions

**Files:**
- Modify: `.env.example`
- Create: `.env.testing.example`
- Modify: `phpunit.xml`
- Modify: `.github/workflows/ci.yml`
- Create: `tests/Support/TestDatabaseGuard.php`
- Create: `tests/Architecture/TestDatabaseSafetyTest.php`
- Modify: `tests/TestCase.php`

**Interfaces:**
- Produces: `Tests\Support\TestDatabaseGuard::assertSafe(string $environment, string $connection, string $database): void`.
- Consumed by: root/package test base classes before database-reset traits can run.

- [ ] **Step 1: Write failing configuration and guard tests**

  Parse `phpunit.xml` and assert `APP_ENV=testing`, `DB_CONNECTION=pgsql`, and `DB_DATABASE=rehla_testing`. Table-test that the guard throws `RuntimeException` for environment `local` or `production`, connection `sqlite`, and database `:memory:`, `rehla`, `testing`, or empty; accept only `testing` + `pgsql` + a name ending `_testing`.

- [ ] **Step 2: Verify RED**

  Run: `./vendor/bin/pest tests/Architecture/TestDatabaseSafetyTest.php`

  Expected: XML assertion fails with actual `sqlite`. If the missing guard errors, add only its signature with an empty body, rerun, and verify unsafe cases fail normally.

- [ ] **Step 3: Implement minimum GREEN**

  Make the guard throw before any connection opens unless all predicates hold. Call it from `Tests\TestCase::setUp()` with the three PHPUnit environment values immediately before `parent::setUp()`, so a `RefreshDatabase` trait cannot run first.

  Use these committed, non-secret PostgreSQL defaults in `.env.example` and `.env.testing.example` (the latter uses `rehla_testing`):

  ```dotenv
  DB_CONNECTION=pgsql
  DB_HOST=127.0.0.1
  DB_PORT=5432
  DB_DATABASE=rehla
  DB_USERNAME=postgres
  DB_PASSWORD=
  ```

  Change CI triggers from `master` to `main`, service database to `rehla_testing`, add `pdo_pgsql`, and remove SQLite extensions. Keep CI test credentials only in job environment and never echo them.

- [ ] **Step 4: Verify GREEN**

  ```bash
  ./vendor/bin/pest tests/Architecture/TestDatabaseSafetyTest.php
  APP_ENV=testing DB_CONNECTION=pgsql DB_DATABASE=rehla_testing ./vendor/bin/pest tests/Architecture
  ```

  Expected: safety tests pass without connecting; no secret values appear.

- [ ] **Step 5: REFACTOR and verify**

  Centralize predicates in `TestDatabaseGuard`; re-run focused and architecture tests.

- [ ] **Step 6: Task review and commit**

  ```bash
  git diff --check
  git add .env.example .env.testing.example phpunit.xml .github/workflows/ci.yml tests/Support/TestDatabaseGuard.php tests/Architecture/TestDatabaseSafetyTest.php tests/TestCase.php
  git commit -m "test(rehla-foundation): guard postgresql test database"
  ```

### Task 4: Establish the shared Orchestra Testbench package base

**Files:**
- Create: `tests/Support/RehlaPackageTestCase.php`
- Create: `tests/Fixtures/Foundation/FixturePackageServiceProvider.php`
- Create: `tests/Package/FoundationBootstrapTest.php`
- Modify: `tests/Pest.php`
- Modify: `phpunit.xml`

**Interfaces:**
- Consumes: `TestDatabaseGuard::assertSafe()`.
- Produces: abstract `Tests\Support\RehlaPackageTestCase` with `protected function getPackageProviders($app): array` and `protected function packageProviders(): array`.

- [ ] **Step 1: Write failing package-bootstrap test**

  Register a `Package` testsuite in `phpunit.xml` and bind that directory to `RehlaPackageTestCase` in `tests/Pest.php`. The fixture provider binds `foundation.fixture` to literal `booted`; the focused Pest test supplies it through `packageProviders()`. Assert Testbench resolves the binding and reports `testing`, `pgsql`, and `rehla_testing`.

- [ ] **Step 2: Verify RED**

  Run: `./vendor/bin/pest tests/Package/FoundationBootstrapTest.php`

  Expected: after resolving compile-only missing-class errors, fail because the shared base does not boot the fixture provider/configuration.

- [ ] **Step 3: Implement minimum GREEN**

  Extend `Orchestra\Testbench\TestCase`. In `defineEnvironment()`, set only test environment, PostgreSQL connection/database, array cache/session, sync queue, and array mailer; call the guard. Implement `getPackageProviders()` as a final bridge to `packageProviders()`.

- [ ] **Step 4: Verify GREEN**

  Run: `./vendor/bin/pest tests/Package/FoundationBootstrapTest.php`

  Expected: provider binding and safe configuration assertions pass.

- [ ] **Step 5: REFACTOR and verify**

  Keep fixture behavior under `tests/Fixtures`; leave all first-party providers untouched. Run `./vendor/bin/pest tests/Architecture tests/Package`.

- [ ] **Step 6: Task review and commit**

  ```bash
  git diff --check
  git add phpunit.xml tests/Pest.php tests/Support/RehlaPackageTestCase.php tests/Fixtures/Foundation/FixturePackageServiceProvider.php tests/Package/FoundationBootstrapTest.php
  git commit -m "test(rehla-foundation): add shared package testbench base"
  ```

### Task 5: Add Foundation formatting and static-analysis gates

**Files:**
- Modify: `composer.json`
- Modify: `composer.lock`
- Create: `phpstan.neon`

**Interfaces:**
- Produces Composer scripts `format:test` and `analyse`.

- [ ] **Step 1: Verify RED**

  ```bash
  composer format:test
  composer analyse
  ```

  Expected: both exit nonzero because the scripts are undefined. These are configuration gates.

- [ ] **Step 2: Implement minimum GREEN**

  Confirm Packagist still reports Larastan 3.10 support for Illuminate 13 and PHP 8.5, then run:

  ```bash
  composer require --dev larastan/larastan:^3.10 --with-all-dependencies --no-interaction
  ```

  Add scripts:

  ```json
  "format:test": "pint --test",
  "analyse": "phpstan analyse --memory-limit=1G"
  ```

  Create:

  ```neon
  includes:
      - vendor/larastan/larastan/extension.neon

  parameters:
      level: 6
      paths:
          - app
          - bootstrap
          - config
          - packages/rehla
          - routes
          - tests
      excludePaths:
          analyse:
              - bootstrap/cache/*.php
  ```

- [ ] **Step 3: Verify GREEN**

  ```bash
  composer validate --strict
  composer format:test
  composer analyse
  ```

  Expected: all exit 0 with no ignored-error baseline.

- [ ] **Step 4: REFACTOR and verify**

  Remove only redundant analyzer configuration; do not weaken level 6 or add blanket ignores. Re-run all three gates.

- [ ] **Step 5: Task review and commit**

  ```bash
  git diff --check
  git add composer.json composer.lock phpstan.neon
  git commit -m "chore(rehla-foundation): add php quality gates"
  ```

### Task 6: Establish the Alpine/Tailwind/Vite and Playwright smoke gate

**Files:**
- Modify: `package.json`
- Create/Modify: `package-lock.json`
- Modify: `resources/js/app.js`
- Modify: `vite.config.js`
- Create: `resources/views/foundation-smoke.blade.php`
- Modify: `routes/web.php`
- Create: `playwright.config.ts`
- Create: `tests/e2e/foundation-smoke.spec.ts`
- Modify: `.github/workflows/ci.yml`

**Interfaces:**
- Produces: warning-free compiled Alpine entrypoint, testing-only `/_foundation/smoke`, and npm scripts `test:e2e`/`test:e2e:install`.
- Consumed by: the final Foundation gate.

- [ ] **Step 1: Write the failing browser test**

  Create the browser test before adding dependencies, scripts, routes, views, or runtime code:

  ```ts
  import { expect, test } from '@playwright/test';

  test('Laravel test application is healthy', async ({ request }) => {
      const response = await request.get('/up');
      expect(response.status()).toBe(200);
  });

  test('compiled Alpine entrypoint initializes', async ({ page }) => {
      await page.goto('/_foundation/smoke');
      await expect(page.locator('[data-foundation-status]')).toHaveText('ready');
  });
  ```

  Run `npm run test:e2e`.

  Expected RED: npm exits nonzero because the local script/runner is absent. Do not use transient `npx` installation.

- [ ] **Step 2: Implement minimum GREEN**

  Create the Blade fixture:

  ```html
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <main x-data="{ status: 'pending' }" x-init="status = 'ready'">
      <span data-foundation-status x-text="status">pending</span>
  </main>
  ```

  Register it only in testing:

  ```php
  if (app()->environment('testing')) {
      Route::view('/_foundation/smoke', 'foundation-smoke');
  }
  ```

  ```bash
  npm install --save-dev alpinejs@^3.16.2 fontaine@^0.8.1 @playwright/test@^1.62.1
  ```

  ```js
  import Alpine from 'alpinejs';

  window.Alpine = Alpine;
  Alpine.start();
  ```

  Add:

  ```json
  "test:e2e": "playwright test",
  "test:e2e:install": "playwright install chromium"
  ```

  Configure `playwright.config.ts` with `testDir: './tests/e2e'`, base URL `http://127.0.0.1:8000`, one retry only in CI, trace on first retry, and:

  ```ts
  webServer: {
      command: 'npm run build && php artisan serve --env=testing --host=127.0.0.1 --port=8000',
      url: 'http://127.0.0.1:8000/up',
      reuseExistingServer: !process.env.CI,
      timeout: 120_000,
  },
  ```

- [ ] **Step 3: Verify GREEN**

  ```bash
  npm install
  npm run build
  APP_ENV=testing php artisan route:list --path=_foundation/smoke
  APP_ENV=production php artisan route:list --path=_foundation/smoke
  npm run test:e2e:install
  npm run test:e2e -- tests/e2e/foundation-smoke.spec.ts
  ```

  Expected: warning-free build, route present only in testing, and 2 Chromium tests pass.

- [ ] **Step 4: Add CI gates**

  Add Node 24 setup with npm cache, `npm ci`, build, Chromium installation with dependencies, Composer formatting/static analysis, and focused Playwright after Pest. Keep test-only PostgreSQL values in job environment; do not echo them.

- [ ] **Step 5: REFACTOR and verify**

  Keep one browser project, two stable assertions, and a minimal fixture. Add no Dashboard component/layout. Re-run Composer validation, build, route checks, and focused Playwright.

- [ ] **Step 6: Task review and commit**

  ```bash
  git diff --check
  git add package.json package-lock.json resources/js/app.js vite.config.js resources/views/foundation-smoke.blade.php routes/web.php playwright.config.ts tests/e2e/foundation-smoke.spec.ts .github/workflows/ci.yml
  git commit -m "test(rehla-foundation): add frontend smoke gate"
  ```

### Task 7: Run the Foundation gate and document fresh evidence

**Files:**
- Create: `docs/superpowers/evidence/foundation-gate.md`

**Interfaces:**
- Consumes: every executable gate from Tasks 1–6.
- Produces: redacted verification record with command, UTC timestamp, exit status, pass count, and limitations.

- [ ] **Step 1: Run every fresh gate before writing evidence**

  Run separately:

  ```bash
  php -v
  composer --version
  php artisan about --only=environment
  composer validate --strict
  composer format:test
  composer analyse
  ./vendor/bin/pest tests/Architecture
  php artisan test
  npm ci
  npm run build
  npm run test:e2e -- tests/e2e/foundation-smoke.spec.ts
  git diff --check
  ```

  Invoke `superpowers:systematic-debugging` before any fix if a command fails. Never copy environment/credential values into evidence.

- [ ] **Step 2: Write the evidence document**

  Record the literal heading `# Foundation Gate Evidence`; the actual UTC timestamp from `date -u +%Y-%m-%dT%H:%M:%SZ`; actual short SHA from `git rev-parse --short HEAD`; observed PHP, Composer, and Laravel versions; and the redacted statement `Database target: PostgreSQL (pgsql); database name and credentials redacted`.

  Add a Markdown table with one row per Step 1 gate. Each row contains the exact command, observed numeric exit status, and observed pass/error count or warning-free build summary. Add a `## Limitations` section containing either the literal word `None` or only limitations demonstrated by the fresh output.

  This documentation task is exempt from a fake RED cycle: truth comes from the executable gates, not source-text testing of human prose.

- [ ] **Step 3: Verify evidence**

  Compare every row to immediate output, confirm no secrets/sensitive content, then run `git diff --check` and `git status --short`.

- [ ] **Step 4: Task review and commit**

  ```bash
  git add docs/superpowers/evidence/foundation-gate.md
  git commit -m "docs(rehla-foundation): record foundation gate evidence"
  ```

## Final Self-Review / Completion Gate

- [ ] Re-read both binding specs and map every Foundation responsibility to a task/test.
- [ ] Confirm M0 responsibilities were preserved, not recreated.
- [ ] Search produced files for unfinished-marker strings, empty methods, broad analysis ignores, and accidental secret values.
- [ ] Confirm no Core, DataGrid, Dashboard, API, or domain behavior was added.
- [ ] Run `./vendor/bin/pest tests/Architecture` and `php artisan test`.
- [ ] Run `composer validate --strict`, `composer format:test`, and `composer analyse`.
- [ ] Verify Laravel bootstrap with `php artisan about --only=environment`; verify the smoke route under testing and production.
- [ ] Run `npm ci`, `npm run build`, and focused Playwright.
- [ ] Run `git diff --check`; inspect `git diff --stat`, complete diff, and `git status --short` without staging user-owned changes.
- [ ] Use `superpowers:requesting-code-review` for whole-unit review on the most capable available model, pointing to all ledger rulings/deferred findings.
- [ ] Resolve Critical/Important findings with one fix wave and one scoped re-review using `superpowers:receiving-code-review`.
- [ ] Use `superpowers:verification-before-completion` with fresh output before stating Foundation is complete.
- [ ] Use `superpowers:finishing-a-development-branch`; do not merge or push automatically.
