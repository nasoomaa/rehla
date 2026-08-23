<?php

use Rehla\Core\Providers\CoreServiceProvider;
use Tests\Support\RehlaPackageTestCase;

use Tests\Support\ProvidesCorePackage;

uses(\Tests\Support\CorePackageTestCase::class);

test('core package boots with safe PostgreSQL testing configuration', function () {
    expect($this->app['config']->get('app.env'))->toBe('testing')
        ->and($this->app['config']->get('database.default'))->toBe('pgsql')
        ->and($this->app['config']->get('database.connections.pgsql.database'))->toBe('rehla_testing');
});

test('core service provider is loaded in the application', function () {
    $loaded = array_keys($this->app->getLoadedProviders());

    expect($loaded)->toContain(CoreServiceProvider::class);
});

test('core package composer.json declares no first-party rehla business dependencies', function () {
    $manifest = json_decode(
        file_get_contents(dirname(__DIR__, 3) . '/packages/rehla/core/composer.json'),
        true,
        512,
        JSON_THROW_ON_ERROR
    );

    $firstPartyDeps = array_filter(
        array_keys($manifest['require'] ?? []),
        static fn (string $dep): bool => str_starts_with($dep, 'rehla/')
    );

    // Core sits at the DAG root — no first-party Rehla dependencies allowed.
    expect(array_values($firstPartyDeps))->toBe([]);
});
