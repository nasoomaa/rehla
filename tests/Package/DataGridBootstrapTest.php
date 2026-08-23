<?php

use Illuminate\Support\Facades\App;
use Rehla\DataGrid\Providers\DataGridServiceProvider;
use Tests\Support\ProvidesDataGridPackage;

uses(ProvidesDataGridPackage::class);

test('datagrid package service provider is bound', function () {
    expect(App::getProvider(DataGridServiceProvider::class))->not->toBeNull();
});

test('datagrid package composer.json declares no first-party rehla business dependencies', function () {
    $manifest = json_decode(
        file_get_contents(dirname(__DIR__, 2) . '/packages/Rehla/DataGrid/composer.json'),
        true,
        512,
        JSON_THROW_ON_ERROR
    );

    $requires = $manifest['require'] ?? [];
    
    // Core is allowed
    unset($requires['rehla/core']);

    $firstPartyDeps = array_filter(
        array_keys($requires),
        fn ($pkg) => str_starts_with($pkg, 'rehla/')
    );

    expect($firstPartyDeps)->toBeEmpty();
});
