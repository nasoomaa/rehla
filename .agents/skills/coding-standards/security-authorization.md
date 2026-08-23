# Authorization

## Contents

- [Admin: how a route is authorized](#admin-how-a-route-is-authorized)
- [The fail-closed rule](#the-fail-closed-rule)
- [Two-factor](#two-factor)
- [API (Flutter): ownership, not permissions](#api-flutter-ownership-not-permissions)
- [What to check on a new route](#what-to-check-on-a-new-route)

## Admin: how a route is authorized

Three things cooperate:

1. **`packages/rehla/dashboard/src/Config/acl.php`** maps a permission key to the route names it covers.
2. **ACL middleware** resolves the current route name and refuses it when the role does not hold the mapped key.
3. **`Gate::allows($key)`** (via `spatie/laravel-permission`) is called in controllers and views to gate actions and hide controls.

> Anything not listed here and not mapped in `acl.php` is refused, so a route
> added without an ACL entry fails closed instead of being silently open to
> every role.

So a missing ACL entry is a **broken feature for custom roles**, not an open door. Always exercise a custom role — that is what the ACL Playwright specs do.

**Do not use `bouncer()->hasPermission()`** — this is a Bagisto helper that does not exist in Rehla. Use the standard Laravel Gate facade or Spatie helpers:

```php
// In controllers
Gate::authorize('catalog.services.create');

// In Blade
@can('catalog.services.create')
    <a href="{{ route('admin.catalog.services.create') }}">
        <div class="primary-button">
            {{ trans('dashboard::app.admin.create') }}
        </div>
    </a>
@endcan
```

## The fail-closed rule

A route with **no ACL entry** is:

| Role | Result |
|---|---|
| Super Admin (`permission_type = all`) | reachable |
| any custom role | `401` |

The practical consequence: a new route tested only as a super-admin looks fine
and 401s for everyone else. Always exercise a custom role.

## Two-factor

The middleware lets exactly the 2FA setup, verification, and logout routes past the 2FA check. A session that has passed the password but not the second factor is **partially authenticated**. Any new route reachable in that state must not change security settings, read customer data, or act on an order.

## API (Flutter): ownership, not permissions

Customers have no roles. Authorization is **ownership**, enforced by scoping the
query to the authenticated customer:

```php
// Always scope to the authenticated user's guard
$query->where('customer_id', auth()->guard('sanctum')->id());
```

The rule: **an id from the request never selects a row on its own.** It is always
combined with the owner. Otherwise incrementing an order id in the URL reads
someone else's order — the classic IDOR, and the easiest real vulnerability to
introduce in this codebase.

This applies to orders, applications, documents, addresses, and the cart. A DataGrid used in the API too: its `prepareQueryBuilder()` must carry the customer filter.

A guest cart is owned by the session, not a customer id — check how the surrounding code identifies it rather than inventing a scheme.

## What to check on a new route

1. **Is it in `acl.php`?** If not, and not deliberately unrestricted, custom roles get a `401`.
2. **Does the controller check too?** Middleware covers the route name; a controller acting on an id still needs to confirm the actor may touch *that record*.
3. **Is the gate in the view mirrored on the server?** A `@can` check around a button is presentation only.
4. **API: is the query scoped to the owner?**
5. **Does a custom role actually reach it?** Exercise it, do not reason about it.
6. **Mass actions too.** `mass_delete` and `mass_update` take an array of ids from the browser; each needs the same permission and the same ownership scope as the single-record path.
