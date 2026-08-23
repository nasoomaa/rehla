---
name: change-verification
description: Use when a Rehla change is about to be called done, or when asked to run the verification gates — code style, tests, end-to-end tests and translation completeness. Trigger phrases include "verify", "is this done", "run the gates", "pint", "pest", "playwright", "translations check", "ready to commit".
license: MIT
---

# Change Verification

The completion gate for Rehla. A change is not done until every gate its diff
reaches has passed and been reported.

## The four gates

| # | Gate | Command | Applies when |
|---|---|---|---|
| 1 | Style | `vendor/bin/pint --test` | any `.php` changed |
| 2 | Unit/Feature Tests | `vendor/bin/pest` | any `.php` changed |
| 3 | Architecture Tests | `vendor/bin/pest tests/Architecture` | any dependency rule change |
| 4 | E2E | `npx playwright test --config=tests/e2e-pw/playwright.config.ts` | any view, JS, CSS or route changed |

Run them in that order — style is seconds, E2E is minutes, and a Pint failure
makes the rest moot.

### 1. Style

```bash
vendor/bin/pint          # fix
vendor/bin/pint --test   # then confirm: CI runs this form
```

Pint does not format `.blade.php`. Blade style is applied by hand — see the
`coding-standards` skill.

### 2. Unit/Feature Tests

```bash
vendor/bin/pest                                             # everything
vendor/bin/pest packages/rehla/media/tests/Feature         # one directory
vendor/bin/pest --testsuite="Media Feature Test"           # one suite
vendor/bin/pest tests/Package/CoreBootstrapTest.php        # single file
```

Suites live in `phpunit.xml`, one per package that has tests. A package with no
`tests/` directory has no suite; adding a `<testsuite>` for a path that does not
exist makes PHPUnit error.

### 3. Architecture Tests

Architecture tests enforce one-way dependency rules between Rehla packages:

```bash
vendor/bin/pest tests/Architecture          # all architecture tests
```

Run these any time you add a dependency between packages — a failing test
means you introduced a circular or illegal dependency.

### 4. End-to-end

The Dashboard E2E suite runs from the dashboard package:

```bash
cd packages/rehla/dashboard
npx playwright test --config=tests/e2e-pw/playwright.config.ts
```

Locally, run the spec files your change touches rather than the whole suite.

## The security checkpoint

Not a gate — there is no command that returns "secure". It is a question the
diff has to answer before the work is called done:

> Does this change touch authorization, rendered output, user input, uploads,
> raw SQL, secrets or payments?

If yes, load **`coding-standards`** and work its checklist for the surfaces the
diff actually touches. If no, say so — "no authorization, output or input
surfaces touched" — the same way a skipped Playwright run is stated rather than
left silent.

The gates above cannot answer this. Pint has no opinion on an unscoped query,
and a test suite passes just as happily with an IDOR in it.

## Establish the baseline before you blame your change

**Never report a failure count as a regression without comparing.** Revert your
change, run the same command, and diff the failing test **names** — not the
counts, which move on their own:

```bash
vendor/bin/pest <path> 2>&1 | grep -E "^  ⨯" | sed 's/ *[0-9.]*s *$//' | sort > /tmp/with.txt
# revert the change, re-run into /tmp/without.txt
comm -23 /tmp/with.txt /tmp/without.txt   # empty means you introduced nothing
```

An empty diff is the evidence that the gate passed. A count that went 3 → 4 is
not evidence of anything.

## Rules

- **A gate you did not run is a gate that failed.** Report each one explicitly,
  including the ones the diff did not reach: "no view or JS changes — Playwright
  skipped" is a result; silence is not.
- **Fix the cause, never the check.** Do not delete or skip a test, loosen an
  assertion, or add a Pint exclusion to reach green.
- **A pre-existing failure you did not cause is still reported**, with the
  evidence that it pre-dates the change.
- **Prove a fix by breaking it.** When a change fixes a bug, revert the fix and
  watch the new test fail. A test that passes both ways guards nothing — it is
  the most common way a regression test is born dead.
- **Rebuild assets after any frontend change**, then re-run the E2E gate:
  `cd packages/rehla/dashboard && npm run build`.
- **Do not commit or stage** as part of verification unless asked.

## Common mistakes

- **Reporting counts instead of names.** Two runs of the same suite can differ
  without any code change; only the name diff is meaningful.
- **Running Pint over the whole repo and reporting someone else's debt.** Scope
  it: `vendor/bin/pint --test <changed paths>`.
- **Skipping Architecture tests.** A dependency added without a boundary test
  update can silently break the DAG.
- **Skipping E2E because "it is only a Blade change".** Views are exactly what
  the E2E gate covers.
