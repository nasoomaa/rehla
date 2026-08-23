<?php

/**
 * Boundary tests for the rehla/core package.
 *
 * Verifies that Core only depends on the framework and itself,
 * and does not import any Rehla business-domain namespace.
 */

arch('core package imports only Laravel and itself')
    ->expect('Rehla\Core')
    ->toOnlyUse([
        'Illuminate',
        'Rehla\Core',
    ]);

test('core contracts exist and are interfaces', function () {
    expect(interface_exists(\Rehla\Core\Contracts\MenuRegistry::class))->toBeTrue()
        ->and(interface_exists(\Rehla\Core\Contracts\AclRegistry::class))->toBeTrue()
        ->and(interface_exists(\Rehla\Core\Contracts\SystemConfigRepository::class))->toBeTrue()
        ->and(interface_exists(\Rehla\Core\Contracts\CurrentLocale::class))->toBeTrue()
        ->and(interface_exists(\Rehla\Core\Contracts\CurrentCurrency::class))->toBeTrue();
});

arch('core package does not import forbidden business namespaces')
    ->expect('Rehla\Core')
    ->not->toUse([
        'Rehla\Datagrid',
        'Rehla\Rule',
        'Rehla\Media',
        'Rehla\ImageCache',
        'Rehla\Customers',
        'Rehla\AdminUsers',
        'Rehla\Catalog',
        'Rehla\CartRule',
        'Rehla\Sales',
        'Rehla\Payment',
        'Rehla\Checkout',
        'Rehla\Applications',
        'Rehla\Notifications',
        'Rehla\AuditLog',
        'Rehla\Dashboard',
        'Rehla\Api',
    ]);
