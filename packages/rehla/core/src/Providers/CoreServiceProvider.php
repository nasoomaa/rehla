<?php

namespace Rehla\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Rehla\Core\Acl\AclManager;
use Rehla\Core\Contracts\AclRegistry;
use Rehla\Core\Contracts\MenuRegistry;
use Rehla\Core\Contracts\SystemConfigRepository;
use Rehla\Core\Menu\MenuManager;
use Rehla\Core\SystemConfig\DatabaseSystemConfigRepository;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MenuRegistry::class, MenuManager::class);
        $this->app->singleton(AclRegistry::class, AclManager::class);
        $this->app->singleton(SystemConfigRepository::class, DatabaseSystemConfigRepository::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }
}
