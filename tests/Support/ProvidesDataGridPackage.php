<?php

namespace Tests\Support;

use Rehla\DataGrid\Providers\DataGridServiceProvider;

trait ProvidesDataGridPackage
{
    protected function packageProviders(): array
    {
        return [DataGridServiceProvider::class];
    }
}
