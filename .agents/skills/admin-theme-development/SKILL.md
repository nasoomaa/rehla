---
name: admin-theme-development
description: Use when creating or changing the Rehla Dashboard package or its themes — admin layouts, Blade component overrides, or the Vite asset pipeline using rehla-vite. Trigger phrases include "admin theme", "admin layout", "admin panel styling", "theme package", "vite", "tailwind", "dashboard package".
requires: coding-standards
license: MIT
---

# Dashboard & Theme Development

## Overview

The Rehla Admin Panel is located at `packages/rehla/dashboard`. It supports a theme system allowing assets and views to be compiled and served dynamically based on `config/themes.php` and `config/rehla-vite.php`.

## When to Apply

Activate this skill when:
- Creating or editing views inside `packages/rehla/dashboard`
- Customizing admin panel styling using Tailwind CSS
- Overriding default admin templates or adding new layouts
- Working with the Vite asset pipeline (`@rehlaVite`)

## Rehla Dashboard Theme Architecture

### Core Components

| Component | Purpose | Location |
|-----------|---------|----------|
| **Theme Configuration** | Defines available admin themes | `config/themes.php` |
| **Vite Configuration** | Registers Vite paths for Rehla | `config/rehla-vite.php` |
| **Views Path** | Blade template files | `packages/rehla/dashboard/src/Resources/views/` |
| **Assets Path** | CSS, JS, images | `packages/rehla/dashboard/src/Resources/assets/` |
| **Dashboard Provider** | Loads views and components | `packages/rehla/dashboard/src/Providers/DashboardServiceProvider.php` |

### Key Configuration Properties

```php
// config/themes.php
'admin-default' => 'default',

'admin' => [
    'default' => [
        'name' => 'Default',
        'assets_path' => 'public/themes/admin/default',
        'views_path' => 'resources/admin-themes/default/views',
        'vite' => [
            'hot_file' => 'admin-default-vite.hot',
            'build_directory' => 'themes/admin/default/build',
            'package_assets_directory' => 'src/Resources/assets',
        ],
    ],
],
```

```php
// config/rehla-vite.php
'viters' => [
    'admin' => [
        'hot_file' => 'admin-default-vite.hot',
        'build_directory' => 'themes/admin/default/build',
        'package_assets_directory' => 'src/Resources/assets',
    ],
],
```

## Reference files — load only what the current task needs

| File | Load when |
|---|---|
| [dashboard-package.md](dashboard-package.md) | Understanding the Dashboard package structure |
| [assets.md](assets.md) | The Vite pipeline, `@rehlaVite`, and the dev-server workflow |
| [layouts.md](layouts.md) | Dashboard layouts, Blade components, custom layouts |
| [reference.md](reference.md) | Package layout, key files, pitfalls, testing |

**REQUIRED SUB-SKILL:** Use change-verification before calling any change done.
