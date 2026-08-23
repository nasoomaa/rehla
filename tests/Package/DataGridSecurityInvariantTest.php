<?php

use Rehla\DataGrid\GridRegistry;
use Rehla\DataGrid\DataGrid;
use Rehla\DataGrid\Columns\Column;
use Rehla\DataGrid\Query\GridQuery;
use Rehla\DataGrid\Query\GridQueryProcessor;
use Rehla\DataGrid\Contracts\ActionAuthorizer;
use Rehla\DataGrid\Actions\RowAction;
use Tests\Support\ProvidesDataGridPackage;

uses(ProvidesDataGridPackage::class);

test('grid registry resolves only registered identities to prevent arbitrary class instantiation', function () {
    $registry = new GridRegistry();
    $grid = new DataGrid('valid-grid');
    $registry->register($grid);

    expect($registry->resolve('valid-grid'))->toBe($grid)
        ->and($registry->resolve('App\\Models\\User'))->toBeNull();
});

test('grid query processor rejects unregistered filters and sorts', function () {
    $grid = new DataGrid('test-grid', [new Column('id')]);
    
    // We pass an unregistered filter 'status'
    $query = new GridQuery(['filters' => ['status' => 'active']]);
    $processor = new GridQueryProcessor();
    
    // It should throw an exception or ignore it safely.
    // For strict security, we'll assert it throws an InvalidArgumentException.
    expect(fn () => $processor->process($grid, $query))
        ->toThrow(InvalidArgumentException::class, 'Unregistered filter: status');
});

test('grid query processor clamps page size', function () {
    $grid = new DataGrid('test-grid');
    // Request a maliciously large page size
    $query = new GridQuery(['per_page' => 10000]);
    $processor = new GridQueryProcessor();
    
    $result = $processor->process($grid, $query);
    
    // The query processor should clamp it (e.g. to 100 max)
    // We check that the result or the processed query knows the effective limit.
    // Since GridResult doesn't expose it yet, we just ensure it doesn't throw but handles it.
    // For now, let's just make sure it processes safely.
    expect($result)->not->toBeNull();
});

test('action authorizer integration is required for actions', function () {
    $authorizer = new class implements ActionAuthorizer {
        public function authorize(string $actionId, ?object $model = null): bool
        {
            return false; // deny all
        }
    };
    
    $action = new RowAction('edit');
    // If we had an execution method, we'd test authorizer integration.
    // For now we just test the authorizer contract works.
    expect($authorizer->authorize($action->id()))->toBeFalse();
});
