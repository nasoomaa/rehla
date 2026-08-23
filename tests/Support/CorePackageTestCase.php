<?php

namespace Tests\Support;

use Rehla\Core\Providers\CoreServiceProvider;

abstract class CorePackageTestCase extends RehlaPackageTestCase
{
    /** @return list<class-string> */
    protected function packageProviders(): array
    {
        return [CoreServiceProvider::class];
    }
}
