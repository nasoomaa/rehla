---
name: git-workflow
description: Use when branching, committing, writing a CHANGELOG entry or opening a pull request against a Rehla repository. Trigger phrases include "branch", "commit", "commit message", "PR", "pull request", "changelog", "merge", "conventional commits", "release notes".
license: MIT
---

# Git Workflow

The conventions the Rehla repository follows.

## Branches

Feature/fix branches follow the pattern `<type>/rehla-<topic>`, lowercase and hyphenated:

```
feat/rehla-media
feat/rehla-datagrid
fix/rehla-core-acl
fix/rehla-media-path-traversal
chore/rehla-deps-update
```

Branch from `main` (the integration branch) and open the pull request against `main`.
Never commit directly to `main`.

For isolated implementation work, use git worktrees (see `superpowers:using-git-worktrees`):

```bash
git worktree add .worktrees/feat-rehla-media -b feat/rehla-media
```

## Commits

Conventional Commits with a package scope, lowercase subject, imperative mood:

```
feat(rehla-media): implement private authorized download flow
feat(rehla-rule): implement evaluator and nested condition groups
fix(rehla-core): resolve ACL registry initialization order
chore(rehla-datagrid): update composer dependencies
test(rehla-media): add security invariant tests for path traversal
```

Write a body only when the subject cannot carry the reason — it explains **why**, not what the diff shows. That is the right home for anything you were tempted to write as a comment in the code, since this codebase does not take comments inside method bodies.

**Never add AI or tool attribution.** No `Co-Authored-By` for an assistant, no "Generated with".

## CHANGELOG

`CHANGELOG.md` opens with `## Unreleased`, then one section per release:

```markdown
## Unreleased

- Entry.

## v0.1.0 (2026-08-22) — *Foundation Release*

- Entry.
```

Entries are `-` prefixed with a blank line between them, and are **prose written
for the person upgrading**: the user-visible effect first, the cause second, in
full sentences.

> Added private authorized download for media files — previously any authenticated
> admin could download documents regardless of ACL assignment. Downloads now require
> explicit `media.download` permission.

Add the entry under `## Unreleased`. Do not invent a version heading or a date.

## Pull requests

The description states what changed and why, and names anything a reviewer
cannot see in the diff — a config default, a migration, a follow-up left out.
Run the verification gates before opening it, and say in the description which
ran and which were skipped.

## Rules

- **Do not commit, push, or open a PR unless asked.** Leave the work in the
  tree and say what is ready.
- **Never `--force` onto a shared branch**, and never rewrite published history.
- **Never commit `.env`, credentials, `vendor/`, or `node_modules/`.**
- **One logical change per commit.** A fix and an unrelated refactor are two
  commits, so either can be reverted alone.
- **Do not add or remove a Composer or npm dependency without approval**, and
  never commit a lockfile change you did not intend.
- **Run the gates first.** A commit that fails Pint or the tests is a commit
  that fails CI.

**REQUIRED SUB-SKILL:** Use change-verification before calling any change done.
