<?php

namespace Tests\Support;

use Rehla\Core\Providers\CoreServiceProvider;

/**
 * Provides the Core package to Orchestra Testbench for isolation tests.
 */
trait ProvidesCorePackage
{
    /** @return list<class-string> */
    protected function packageProviders(): array
    {
        return [CoreServiceProvider::class];
    }
}
