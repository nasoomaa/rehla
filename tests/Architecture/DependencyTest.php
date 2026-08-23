<?php

test('core package is pure')
    ->expect('Rehla\Core')
    ->toOnlyUse([
        'Illuminate',
        'Rehla\Core',
    ]);

test('catalog package boundaries')
    ->expect('Rehla\Catalog')
    ->toOnlyUse([
        'Illuminate',
        'Rehla\Core',
        'Rehla\Catalog',
    ]);

test('non-presentation packages do not use presentation packages')
    ->expect([
        'Rehla\Core',
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
    ])
    ->not->toUse([
        'Rehla\Dashboard',
        'Rehla\Api',
    ]);
