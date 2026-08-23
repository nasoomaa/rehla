<?php

namespace Tests\Fixtures\Foundation;

use Illuminate\Support\ServiceProvider;

final class FixturePackageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('foundation.fixture', static fn (): string => 'booted');
    }
}
