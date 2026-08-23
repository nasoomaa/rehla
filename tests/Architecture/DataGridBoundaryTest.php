<?php

use Rehla\DataGrid\Contracts\ActionAuthorizer;
use Rehla\DataGrid\Contracts\DataGridContract;
use Rehla\DataGrid\Contracts\ExporterContract;
use Rehla\DataGrid\Contracts\FilterContract;

test('datagrid package does not depend on downstream business packages', function () {
    expect('Rehla\DataGrid')
        ->not->toUse([
            'Rehla\Catalog',
            'Rehla\Order',
            'Rehla\Payment',
            'Rehla\Cart',
            'App\\',
        ]);
});

test('datagrid package contracts are properly defined', function () {
    expect('Rehla\DataGrid\Contracts')
        ->toBeInterfaces();

    $contracts = [
        DataGridContract::class,
        FilterContract::class,
        ExporterContract::class,
        ActionAuthorizer::class,
    ];

    foreach ($contracts as $contract) {
        expect(interface_exists($contract))->toBeTrue();
    }
});
