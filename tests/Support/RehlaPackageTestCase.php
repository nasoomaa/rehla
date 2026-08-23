<?php

namespace Tests\Support;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class RehlaPackageTestCase extends OrchestraTestCase
{
    final protected function getPackageProviders($app): array
    {
        return $this->packageProviders();
    }

    /**
     * @return list<class-string>
     */
    protected function packageProviders(): array
    {
        return [];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set([
            'app.env' => 'testing',
            'database.default' => 'pgsql',
            'database.connections.pgsql.database' => 'rehla_testing',
            'cache.default' => 'array',
            'session.driver' => 'array',
            'queue.default' => 'sync',
            'mail.default' => 'array',
        ]);

        TestDatabaseGuard::assertSafe(
            $app['config']->get('app.env'),
            $app['config']->get('database.default'),
            $app['config']->get('database.connections.pgsql.database'),
        );
    }
}
