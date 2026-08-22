# Rehla Superpowers Runbook

Use one execution unit at a time. Replace `<unit>` with a directory slug from `EXECUTION-ORDER.md`.

## A. Review the design before planning/execution

```text
Use superpowers:brainstorming only if the design needs to change.

Read completely:
docs/superpowers/specs/2026-08-22-rehla-platform-design.md
docs/superpowers/specs/<unit>/rehla-<unit>-design.md

Inspect the current repository and already completed dependency packages.
Do not implement code.
If repository evidence conflicts with the unit design, present the conflict and revise the design through the Superpowers approval gate before implementation.
```

## B. Regenerate/review an implementation plan when design changes

```text
Use superpowers:writing-plans.

Parent spec:
docs/superpowers/specs/2026-08-22-rehla-platform-design.md

Unit spec:
docs/superpowers/specs/<unit>/rehla-<unit>-design.md

Create or revise only:
docs/superpowers/plans/<unit>/rehla-<unit>-implementation.md

Keep tasks independently reviewable. Use exact file paths, explicit interfaces, RED/GREEN commands, focused commits and no placeholders. Do not execute the plan.
```

## C. Execute one approved unit

```text
Use superpowers:subagent-driven-development.

Execute exactly:
docs/superpowers/plans/<unit>/rehla-<unit>-implementation.md

Read its parent and unit specs first.
Use superpowers:using-git-worktrees before implementation.
Run the baseline tests.
Use TDD for every behavior task.
Review every task, maintain the plan-scoped SDD ledger, and do not implement another unit.
Run whole-unit code review and fresh verification at the end.
Do not merge/push/delete the branch automatically; finish through superpowers:finishing-a-development-branch.
```

## D. When an implementation/test fails

```text
Use superpowers:systematic-debugging.

Do not attempt another fix yet.
Reproduce the failure, read the complete error, inspect recent changes and trace the failing data/component boundary. Compare to a working pattern, state one root-cause hypothesis and test it minimally. Once demonstrated, create a failing regression test and fix through superpowers:test-driven-development. Verify fresh before claiming resolution.
```

## E. Final verification for a unit

```text
Use superpowers:verification-before-completion.

Re-read the unit spec and plan. Identify the command proving every completion claim, run it fresh, inspect exit codes/failure counts, and map requirements to evidence. Include focused tests, architecture tests, Composer validation when metadata changed, migrations when schema changed, frontend build/Playwright when UI changed, and git diff/status checks. Report the actual state if any gate fails.
```

## F. Integration choice

```text
Use superpowers:finishing-a-development-branch.

Run the required full verification first. Then present the supported integration choices (local merge, push/PR, keep branch as-is). Do not choose for the user and never discard work without explicit discard confirmation.
```
