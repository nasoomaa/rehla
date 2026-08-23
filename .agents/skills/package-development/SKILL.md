---
name: package-development
description: Use when creating or changing a Rehla package — service providers, migrations, models, contracts, repositories, routes, controllers, Blade views, localization, admin menus, ACL or system configuration. Trigger phrases include "new package", "service provider", "migration", "model", "repository", "controller", "route", "ACL", "admin menu", "system config".
requires: coding-standards
license: MIT
---

# Package Development in Rehla

A Rehla package is a self-contained Laravel module under `packages/rehla/<name>/`
with its own models, controllers, routes, views, migrations and providers. Packages
are registered via standard Laravel `bootstrap/providers.php` — there is no Concord
or Module registry in Rehla.

## Reference files — load only what the current task needs

| File | Load when |
|---|---|
| [core.md](core.md) | Creating a package — directory layout, `composer.json`, providers, registration |
| [data-layer.md](data-layer.md) | Migrations, models, contracts, repositories |
| [ui.md](ui.md) | Routes, controllers, Blade views |
| [features.md](features.md) | Admin menus, ACL, system configuration |

## The shape of a package

```
packages/rehla/<name>/
├── composer.json
├── src/
│   ├── Config/           # menu.php, acl.php, system.php — domain packages only
│   ├── Contracts/        # one interface per model
│   ├── Database/         # Migrations/, Seeders/, Factories/
│   ├── Http/Controllers/ # Admin/ controllers (Dashboard package only)
│   ├── Models/           # Eloquent models implementing their Contract
│   ├── Providers/        # <Name>ServiceProvider
│   ├── Repositories/     # all database access
│   └── Resources/
│       ├── lang/ar/
│       ├── lang/en/
│       └── views/        # Blade templates (Dashboard package only)
└── tests/
    ├── Feature/
    └── Unit/
```

## The rules that are not negotiable

- **Single registration.** Every package registers its `ServiceProvider` in
  `bootstrap/providers.php` and declares a path repository in `composer.json`.
  There is no `config/concord.php`; there is no `ModuleServiceProvider`.
- **Two-part models.** Every entity is a Contract (interface) and a Model
  implementing it. There are no Proxy classes — Rehla does not use Concord.
  Repositories return the **Contract** from `model()`.
- **No business logic in Dashboard.** Domain models, repositories, and services
  live in their domain package. Dashboard owns controllers, form requests, DataGrids,
  and views only.
- **Docblocks, member order, comments, the repository rule and translations**
  are owned by the **`coding-standards`** skill. They apply to every Rehla file.
- **Fix what you touch.** A pre-existing violation in a file you edit is yours.

## Related skills

- **`coding-standards`** — docblocks, member order, comments, repository access, localization.
- **`datagrid-development`** — admin listing pages. `features.md` sketches the DataGrid; that skill owns columns, filters, actions, export and the security rules.
- **`pest-testing`** — tests for what you build.
- **`change-verification`** — the completion gate.

**REQUIRED SUB-SKILL:** Use change-verification before calling any change done.
