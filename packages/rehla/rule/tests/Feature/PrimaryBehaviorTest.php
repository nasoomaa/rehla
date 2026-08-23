<?php

use Rehla\Rule\Conditions\FieldCondition;
use Rehla\Rule\Contracts\OperatorContract;
use Rehla\Rule\Contracts\RuleContext;
use Rehla\Rule\Evaluator;
use Rehla\Rule\Operators\OperatorRegistry;

test('rule evaluator can process a simple field condition', function () {
    $registry = new OperatorRegistry;
    $operator = new class implements OperatorContract
    {
        public function code(): string
        {
            return 'equals';
        }

        public function evaluate(mixed $expected, mixed $actual): bool
        {
            return $expected === $actual;
        }
    };
    $registry->register($operator);

    $evaluator = new Evaluator($registry);

    $context = new class implements RuleContext
    {
        public function value(string $key): mixed
        {
            return $key === 'status' ? 'active' : null;
        }
    };

    $condition = new FieldCondition('status', 'equals', 'active');

    $result = $evaluator->evaluate($condition, $context);

    expect($result)->toBeTrue();

    $conditionFailed = new FieldCondition('status', 'equals', 'inactive');

    $resultFailed = $evaluator->evaluate($conditionFailed, $context);
    expect($resultFailed)->toBeFalse();
});
