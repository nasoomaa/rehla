<?php

namespace Tests\Support;

use Rehla\DataGrid\Providers\DataGridServiceProvider;

abstract class DataGridPackageTestCase extends RehlaPackageTestCase
{
    /** @return list<class-string> */
    protected function packageProviders(): array
    {
        return [DataGridServiceProvider::class];
    }
}
