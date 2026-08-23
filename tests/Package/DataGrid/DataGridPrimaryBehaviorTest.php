<?php

use Rehla\DataGrid\GridRegistry;
use Rehla\DataGrid\DataGrid;
use Rehla\DataGrid\Columns\Column;
use Rehla\DataGrid\Filters\Filter;
use Rehla\DataGrid\Query\GridQuery;
use Rehla\DataGrid\Query\GridQueryProcessor;
use Rehla\DataGrid\Results\GridResult;
use Rehla\DataGrid\Actions\RowAction;
use Rehla\DataGrid\Actions\MassAction;
use Rehla\DataGrid\Contracts\DataGridContract;
use Tests\Support\ProvidesDataGridPackage;

uses(\Tests\Support\DataGridPackageTestCase::class);

test('grid registry can register and resolve a grid', function () {
    $registry = new GridRegistry();
    
    $grid = new class implements DataGridContract {
        public function identity(): string { return 'test-grid'; }
        public function columns(): array { return [new Column('id')]; }
        public function filters(): array { return [new Filter('status')]; }
        public function massActions(): array { return [new MassAction('delete')]; }
    };

    $registry->register($grid);

    expect($registry->resolve('test-grid'))->toBe($grid);
});

test('grid query processor handles empty query parameters safely', function () {
    $grid = new DataGrid('test-grid', [new Column('name')]);
    $query = new GridQuery([]);
    
    $processor = new GridQueryProcessor();
    $result = $processor->process($grid, $query);

    expect($result)->toBeInstanceOf(GridResult::class);
});

test('actions can be instantiated with an id', function () {
    $rowAction = new RowAction('edit');
    $massAction = new MassAction('delete_all');

    expect($rowAction->id())->toBe('edit')
        ->and($massAction->id())->toBe('delete_all');
});
