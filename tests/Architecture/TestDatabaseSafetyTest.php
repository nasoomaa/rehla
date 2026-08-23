<?php

use Tests\Support\TestDatabaseGuard;

test('PHPUnit uses the PostgreSQL testing database configuration', function () {
    $phpunit = new SimpleXMLElement(file_get_contents(dirname(__DIR__, 2).'/phpunit.xml'));
    $environment = [];

    foreach ($phpunit->php->env as $env) {
        $environment[(string) $env['name']] = (string) $env['value'];
    }

    expect($environment['APP_ENV'])->toBe('testing')
        ->and($environment['DB_CONNECTION'])->toBe('pgsql')
        ->and($environment['DB_DATABASE'])->toBe('rehla_testing');
});

test('rejects unsafe test database configurations', function (string $environment, string $connection, string $database) {
    expect(fn () => TestDatabaseGuard::assertSafe($environment, $connection, $database))
        ->toThrow(RuntimeException::class);
})->with([
    'non-testing environment' => ['local', 'pgsql', 'rehla_testing'],
    'production environment' => ['production', 'pgsql', 'rehla_testing'],
    'SQLite connection' => ['testing', 'sqlite', 'rehla_testing'],
    'in-memory database' => ['testing', 'pgsql', ':memory:'],
    'application database' => ['testing', 'pgsql', 'rehla'],
    'generic testing database' => ['testing', 'pgsql', 'testing'],
    'empty database name' => ['testing', 'pgsql', ''],
]);

test('accepts a PostgreSQL database name ending in testing', function () {
    TestDatabaseGuard::assertSafe('testing', 'pgsql', 'rehla_testing');

    expect(true)->toBeTrue();
});
