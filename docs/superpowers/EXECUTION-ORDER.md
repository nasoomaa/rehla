# Rehla Execution Order and Gates

The order below is dependency-driven. A unit starts only after its direct dependency units have passed their completion gates and their integration choice has produced an accessible base for the next worktree.

| Order | Unit | Direct prerequisites | Gate before next unit |
|---:|---|---|---|
| 00 | `foundation` | none | focused tests + architecture gate + review + fresh verification |
| 01 | `core` | foundation | focused tests + architecture gate + review + fresh verification |
| 02 | `datagrid` | core | focused tests + architecture gate + review + fresh verification |
| 03 | `rule` | core | focused tests + architecture gate + review + fresh verification |
| 04 | `media` | core | focused tests + architecture gate + review + fresh verification |
| 05 | `image-cache` | core, media | focused tests + architecture gate + review + fresh verification |
| 06 | `dashboard-foundation` | core, datagrid, media, image-cache | focused tests + architecture gate + review + fresh verification |
| 07 | `admin-users` | core | focused tests + architecture gate + review + fresh verification |
| 08 | `customers` | core, media | focused tests + architecture gate + review + fresh verification |
| 09 | `catalog` | core, media, image-cache | focused tests + architecture gate + review + fresh verification |
| 10 | `cart-rule` | core, rule, catalog, customers | focused tests + architecture gate + review + fresh verification |
| 11 | `checkout` | core, customers, catalog, cart-rule | focused tests + architecture gate + review + fresh verification |
| 12 | `sales` | core, customers, catalog, checkout | focused tests + architecture gate + review + fresh verification |
| 13 | `payment` | core, sales, media | focused tests + architecture gate + review + fresh verification |
| 14 | `applications` | core, sales, customers, media | focused tests + architecture gate + review + fresh verification |
| 15 | `notifications` | core, customers, sales, payment, applications | focused tests + architecture gate + review + fresh verification |
| 16 | `audit-log` | core, admin-users | focused tests + architecture gate + review + fresh verification |
| 17 | `api` | core, customers, catalog, checkout, sales, payment, applications, media | focused tests + architecture gate + review + fresh verification |
| 18 | `dashboard-integration` | dashboard-foundation, admin-users, customers, catalog, cart-rule, sales, payment, applications, audit-log | focused tests + architecture gate + review + fresh verification |
| 19 | `release-hardening` | all previous units | focused tests + architecture gate + review + fresh verification |


## Parallelism policy

Default to sequential execution because packages form an intentional DAG. Parallel execution is allowed only after `superpowers:dispatching-parallel-agents` proves there are no shared files, unresolved shared interfaces, unfinished prerequisite packages, or shared migrations. Do not parallelize Checkout/Sales/Payment/Applications merely for speed.

## Suggested safe opportunities after prerequisites stabilize

- AdminUsers and Customers can be considered for parallel *investigation/design* after Dashboard Foundation/Core are stable, but implementation still requires checking shared auth/bootstrap files.
- Notifications and AuditLog may be parallelizable after their consumed domain event contracts are stable.
- Release hardening is never parallelized as independent fixes until failures are classified by root cause/domain.

## Failure rule

Any test/build/runtime failure activates `superpowers:systematic-debugging`. Do not stack speculative fixes. Establish root cause, create a failing regression test, then use TDD for the fix.
