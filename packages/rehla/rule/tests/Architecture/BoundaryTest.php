<?php

use Rehla\Rule\Contracts\ConditionContract;
use Rehla\Rule\Contracts\OperatorContract;
use Rehla\Rule\Contracts\RuleContext;
use Rehla\Rule\Contracts\RuleEvaluator;

test('rule package contracts are properly defined', function () {
    expect(interface_exists(RuleContext::class))->toBeTrue()
        ->and(interface_exists(ConditionContract::class))->toBeTrue()
        ->and(interface_exists(OperatorContract::class))->toBeTrue()
        ->and(interface_exists(RuleEvaluator::class))->toBeTrue();
});

test('rule package does not depend on forbidden domains', function () {
    expect('Rehla\Rule')
        ->not->toUse([
            'Rehla\CartRule',
            'Rehla\Checkout',
            'Rehla\Catalog',
            'Rehla\Customers',
            'Rehla\Dashboard',
            'Rehla\Api',
        ]);
});
