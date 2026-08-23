<?php

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
        \Rehla\DataGrid\Contracts\DataGridContract::class,
        \Rehla\DataGrid\Contracts\FilterContract::class,
        \Rehla\DataGrid\Contracts\ExporterContract::class,
        \Rehla\DataGrid\Contracts\ActionAuthorizer::class,
    ];

    foreach ($contracts as $contract) {
        expect(interface_exists($contract))->toBeTrue();
    }
});
