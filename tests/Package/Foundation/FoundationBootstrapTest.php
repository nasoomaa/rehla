<?php

use Tests\Fixtures\Foundation\FixturePackageServiceProvider;
use Tests\Support\RehlaPackageTestCase;



uses(\Tests\Support\FoundationFixturePackageTestCase::class);

test('boots supplied package providers with the safe PostgreSQL testing configuration', function () {
    expect($this->app['foundation.fixture'])->toBe('booted')
        ->and($this->app['config']->get('app.env'))->toBe('testing')
        ->and($this->app['config']->get('database.default'))->toBe('pgsql')
        ->and($this->app['config']->get('database.connections.pgsql.database'))->toBe('rehla_testing');
});
