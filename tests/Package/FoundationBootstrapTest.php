<?php

use Tests\Fixtures\Foundation\FixturePackageServiceProvider;

trait ProvidesFoundationFixturePackage
{
    protected function packageProviders(): array
    {
        return [FixturePackageServiceProvider::class];
    }
}

uses(ProvidesFoundationFixturePackage::class);

test('boots supplied package providers with the safe PostgreSQL testing configuration', function () {
    expect($this->app->make('foundation.fixture'))->toBe('booted')
        ->and($this->app['config']->get('app.env'))->toBe('testing')
        ->and($this->app['config']->get('database.default'))->toBe('pgsql')
        ->and($this->app['config']->get('database.connections.pgsql.database'))->toBe('rehla_testing');
});
