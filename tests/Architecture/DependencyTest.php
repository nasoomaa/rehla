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
