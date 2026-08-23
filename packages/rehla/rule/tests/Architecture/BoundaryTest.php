<?php

use Rehla\Rule\Providers\RuleServiceProvider;

test('rule package contracts are properly defined', function () {
    expect(interface_exists(\Rehla\Rule\Contracts\RuleContext::class))->toBeTrue()
        ->and(interface_exists(\Rehla\Rule\Contracts\ConditionContract::class))->toBeTrue()
        ->and(interface_exists(\Rehla\Rule\Contracts\OperatorContract::class))->toBeTrue()
        ->and(interface_exists(\Rehla\Rule\Contracts\RuleEvaluator::class))->toBeTrue();
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
