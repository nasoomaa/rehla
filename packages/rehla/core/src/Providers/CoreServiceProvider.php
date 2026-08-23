<?php

namespace Rehla\Core\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\Rehla\Core\Contracts\MenuRegistry::class, \Rehla\Core\Menu\MenuManager::class);
        $this->app->singleton(\Rehla\Core\Contracts\AclRegistry::class, \Rehla\Core\Acl\AclManager::class);
        $this->app->singleton(\Rehla\Core\Contracts\SystemConfigRepository::class, \Rehla\Core\SystemConfig\DatabaseSystemConfigRepository::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}
