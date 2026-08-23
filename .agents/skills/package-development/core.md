# Package Structure & Registration

## Package Structure

### Standard Directory Structure

```
packages/rehla/<name>/
├── composer.json
└── src/
    ├── Config/
    │   ├── menu.php       # Dashboard package only
    │   ├── acl.php        # Dashboard package only
    │   └── system.php     # Domain packages that own config fields
    ├── Contracts/
    │   └── {Model}.php    # One interface per model
    ├── Database/
    │   ├── Migrations/
    │   ├── Seeders/
    │   └── Factories/
    ├── Http/
    │   └── Controllers/   # Domain packages: API controllers only
    │                      # Dashboard: Admin controllers
    ├── Models/
    │   └── {Model}.php    # Eloquent model implementing its Contract
    ├── Repositories/
    │   └── {Model}Repository.php
    ├── Providers/
    │   └── {Name}ServiceProvider.php
    └── Resources/
        ├── lang/
        │   ├── ar/app.php
        │   └── en/app.php
        └── views/         # Dashboard package and API package only
```

## Manual Setup

### Create Package Directory

```bash
mkdir -p packages/rehla/my-package/src/Providers
```

### Create Service Provider

**File:** `packages/rehla/my-package/src/Providers/MyPackageServiceProvider.php`

```php
<?php

namespace Rehla\MyPackage\Providers;

use Illuminate\Support\ServiceProvider;

class MyPackageServiceProvider extends ServiceProvider
{
    /**
     * Register package services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Rehla\MyPackage\Contracts\MyModel::class,
            \Rehla\MyPackage\Models\MyModel::class
        );
    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'my-package');
    }
}
```

## Registering Your Package

### 1. Create `composer.json` for the package

**File:** `packages/rehla/my-package/composer.json`

```json
{
    "name": "rehla/my-package",
    "description": "Rehla MyPackage domain package.",
    "type": "library",
    "license": "proprietary",
    "autoload": {
        "psr-4": {
            "Rehla\\MyPackage\\": "src/"
        }
    },
    "require": {
        "rehla/core": "dev-main"
    },
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

### 2. Declare path repository in root `composer.json`

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/rehla/my-package"
        }
    ],
    "require": {
        "rehla/my-package": "dev-main"
    }
}
```

Then run:

```bash
composer require rehla/my-package:dev-main
```

### 3. Register Service Provider

In `bootstrap/providers.php`:

```php
<?php

return [
    App\Providers\AppServiceProvider::class,

    // ... other providers ...

    Rehla\MyPackage\Providers\MyPackageServiceProvider::class,
];
```

### 4. Clear Cache

```bash
php artisan optimize:clear
```

## Service Provider Methods

### Loading Migrations

```php
public function boot(): void
{
    $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
}
```

### Loading Translations

```php
public function boot(): void
{
    $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'my-package');
}
```

### Loading Views (Dashboard package only)

```php
use Illuminate\Support\Facades\Blade;

public function boot(): void
{
    $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'dashboard');
    Blade::anonymousComponentPath(__DIR__ . '/../Resources/views/components', 'dashboard');
}
```

### Merging Config (Admin Menu / ACL — Dashboard package only)

Dashboard owns the centralized `menu.php` and `acl.php`. Other packages do not
merge their own menus; they register their routes and the Dashboard config references them.

```php
public function register(): void
{
    $this->mergeConfigFrom(
        dirname(__DIR__) . '/Config/menu.php',
        'menu.admin'
    );

    $this->mergeConfigFrom(
        dirname(__DIR__) . '/Config/acl.php',
        'acl'
    );
}
```

## Common Pitfalls

- Forgetting to run `composer require rehla/my-package:dev-main` after adding to repositories
- Not registering service provider in `bootstrap/providers.php`
- Not clearing cache after changes
- Incorrect namespace in PSR-4 autoloading
- Not using package prefix for table names
- Using `bouncer()` — it does not exist in Rehla; use `Gate::allows()` and Spatie
- Creating a `ModuleServiceProvider` — Rehla does not use Concord
- Adding `config/concord.php` — it does not exist and is not needed
