## Dashboard Package Structure

The `packages/rehla/dashboard` package acts as the core administrative interface for Rehla. Since we are using the theme system, it is designed to be fully self-contained with its own assets, views, and configuration, integrated seamlessly using `config/themes.php` and `config/rehla-vite.php`.

### Directory Structure

```bash
packages/rehla/dashboard/
├── src/
│   ├── Providers/
│   │   └── DashboardServiceProvider.php
│   ├── Resources/
│   │   ├── assets/       # CSS, JS, images, fonts
│   │   ├── lang/         # ar/en translations
│   │   └── views/        # Blade templates and components
│   └── Config/
│       ├── menu.php      # Dashboard sidebar menus
│       └── acl.php       # Dashboard access control list
├── package.json          # Node dependencies
├── vite.config.js        # Vite compilation rules
├── tailwind.config.js    # Tailwind classes
└── postcss.config.cjs    # PostCSS rules
```

### Dashboard Boilerplate Page

A typical dashboard page uses the `x-dashboard::layouts` layout:

**File:** `packages/rehla/dashboard/src/Resources/views/dashboard/index.blade.php`

```blade
<x-dashboard::layouts>
    <x-slot:title>
        {{ trans('dashboard::app.admin.dashboard.title') }}
    </x-slot>

    <div class="flex gap-4 justify-between max-sm:flex-wrap">
        <h1 class="py-[11px] text-xl text-gray-800 dark:text-white font-bold">
            {{ trans('dashboard::app.admin.dashboard.title') }}
        </h1>

        <div class="flex gap-x-2.5 items-center">
            <button class="primary-button">
                {{ trans('dashboard::app.admin.dashboard.save-settings') }}
            </button>
        </div>
    </div>

    {{-- Dashboard Content --}}
    <div class="mt-8 bg-white dark:bg-gray-900 rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">
            {{ trans('dashboard::app.admin.dashboard.welcome') }}
        </h1>
    </div>
</x-dashboard::layouts>
```

### Registration

To register the Dashboard package:

1. Add it to the root `composer.json` repositories and run `composer require rehla/dashboard:dev-main`.
2. Register `Rehla\Dashboard\Providers\DashboardServiceProvider::class` in `bootstrap/providers.php`.
3. The ServiceProvider should load the views as `dashboard`:
```php
$this->loadViewsFrom(__DIR__ . '/../Resources/views', 'dashboard');
Blade::anonymousComponentPath(__DIR__ . '/../Resources/views/components', 'dashboard');
```
