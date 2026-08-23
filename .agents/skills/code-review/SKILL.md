---
name: code-review
description: Use when reviewing Rehla code changes or a pull request for correctness, convention compliance or quality, or when asked whether a change is ready to merge. Trigger phrases include "review", "code review", "PR review", "is this correct", "conventions", "violations", "code quality", "ready to merge".
requires: coding-standards
license: MIT
---

# Code Review

What to look for in a Rehla change, ordered so the findings that matter arrive
first. Pint and the test suites already decide the mechanical questions — spend
the review on what they cannot see.

## What the tools already cover

Do not spend review effort on these; run them instead.

| Checked by | Covers |
|---|---|
| `vendor/bin/pint --test` | Formatting, spacing, import order, trailing commas |
| `vendor/bin/pest` | Behaviour the suite asserts |
| `vendor/bin/pest tests/Architecture` | Package dependency rules (DAG) |
| Playwright | The browser layer |

If a review comment could have been an exit code, the fix is to run the tool,
not to write the comment.

## Blocking

A change should not merge with any of these outstanding.

**Correctness**

- A query inside a loop, or an N+1 from a missing eager load. The cost is
  invisible on small data and appears on production.
- An unbounded `->get()` on a table that grows — services, orders, customers.
  Paginate or chunk.
- A repository method that touches customer-owned or application-owned rows without
  scoping to the owner.
- A raw fragment (`whereRaw`, `selectRaw`, `DB::raw`, `orderByRaw`) built by
  interpolating a request value.

**Security**

Owned by the **`coding-standards`** skill — load it when the diff touches
authorization, rendered output, input, uploads, raw SQL, secrets or payments,
and work its checklist rather than a remembered list. The two that account for
most real findings:

- A customer/API query selecting by an id from the request without scoping to the
  authenticated customer.
- A DataGrid closure interpolating a value into an HTML attribute without
  `e()` — tags are stripped for you, quotes are not.
- Private media (passports, visa documents, payment proofs) exposed via public URL
  or unguarded download endpoint.

**Architecture**

- `DB::` or model queries outside a repository. The one sanctioned exception is
  a DataGrid's `prepareQueryBuilder()`.
- A new model without its Contract and Repository.
- A package registered in `bootstrap/providers.php` but not in `composer.json` path repositories, or the reverse.
- A domain package depending on a presentation package (`dashboard`, `api`).
- A user-facing string not passed through `trans()`.
- `bouncer()` used instead of `Gate::allows()` or `@can` — `bouncer()` is a Bagisto helper that does not exist in Rehla.

## Worth raising, not blocking

- **Duplication on the third occurrence.** Twice is a coincidence; three times
  is a helper.
- **A method whose body needs a comment to follow.** The codebase forbids
  comments inside method bodies, so this is a signal to extract a named method,
  not to add prose.
- **A docblock or member order violation in a file the change touches.** A
  pre-existing violation in a touched file is the author's to fix.
- **A test that asserts a count or a list position.** Both drift as the database
  grows; assert on the named record instead.
- **An event fired on the single-record path but not the mass-action path**, or
  the reverse.

## How to review

1. **Read the tests first.** They state what the author believes the change
   does. A change with no test for the bug it fixes is the first question.
2. **Ask what breaks it.** For each claim, look for the input that falsifies it —
   an empty collection, a second locale, a guest, an unauthorized role.
3. **Check the reverse.** A regression test that passes with the fix reverted
   guards nothing. Where the fix is subtle, ask the author to show it failing.
4. **Follow one path end to end** — request, form request, controller,
   repository, model, view — rather than reading the diff hunk by hunk. Most
   real defects sit in the seam between two files that each look fine.
5. **Confirm the gates ran**, and which were skipped.

## Writing the finding

State the defect, then the input that triggers it, then the fix. A finding
without a concrete failure is a preference, and should be marked as one.

> `MediaUploadService::store()` writes the file path directly to the `media`
> table without going through the UUID resolver — so on a path with special
> characters the record is unreachable by UUID lookup. Use `MediaUuid::generate()`
> at creation time and store only the UUID.

Separate what you verified from what you suspect. "This is an N+1" and "this
might be an N+1, I did not check the relation" are different claims, and
conflating them costs the author more time than saying so.

**REQUIRED SUB-SKILL:** Use change-verification before calling any change done.
