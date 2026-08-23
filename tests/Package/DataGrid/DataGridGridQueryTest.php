<?php

use Rehla\DataGrid\Columns\Column;
use Rehla\DataGrid\DataGrid;
use Rehla\DataGrid\Filters\Filter;
use Rehla\DataGrid\GridRegistry;
use Rehla\DataGrid\Query\GridQuery;
use Rehla\DataGrid\Query\GridQueryProcessor;
use Tests\Support\DataGridPackageTestCase;

uses(DataGridPackageTestCase::class);

test('grid registry resolves stable IDs', function () {
    $registry = new GridRegistry;
    $grid = new DataGrid('orders-grid', [new Column('total')], [new Filter('status')]);

    $registry->register($grid);

    expect($registry->resolve('orders-grid'))->toBe($grid)
        ->and($registry->resolve('App\\Unknown'))->toBeNull();
});

test('grid query pipeline processes registered sorts and filters correctly', function () {
    $grid = new DataGrid('orders-grid', [new Column('total')], [new Filter('status')]);

    $query = new GridQuery([
        'filters' => ['status' => 'pending'],
        'sort' => 'total',
    ]);

    $processor = new GridQueryProcessor;
    $result = $processor->process($grid, $query);

    expect($result)->not->toBeNull();
});

test('grid query pipeline throws on unregistered sort', function () {
    $grid = new DataGrid('orders-grid', [new Column('total')], [new Filter('status')]);

    $query = new GridQuery(['sort' => 'unregistered_column']);

    $processor = new GridQueryProcessor;

    expect(fn () => $processor->process($grid, $query))
        ->toThrow(InvalidArgumentException::class, 'Unregistered sort column: unregistered_column');
});
