<?php

use Rehla\Rule\Conditions\FieldCondition;
use Rehla\Rule\Contracts\RuleContext;
use Rehla\Rule\Evaluator;
use Rehla\Rule\Operators\OperatorRegistry;

test('unknown operator fails safely and cannot execute arbitrary code', function () {
    $registry = new OperatorRegistry();
    $evaluator = new Evaluator($registry);

    $context = new class implements RuleContext {
        public function value(string $key): mixed { return 'data'; }
    };

    $condition = new FieldCondition('status', 'system("whoami")', 'active');
    
    // Using an unregistered operator should throw an InvalidArgumentException, 
    // never executing the operator string as code.
    expect(fn() => $evaluator->evaluate($condition, $context))
        ->toThrow(InvalidArgumentException::class, 'Operator [system("whoami")] is not registered.');
});

test('unknown fields fail safely depending on context implementation', function () {
    $registry = new OperatorRegistry();
    $operator = new class implements \Rehla\Rule\Contracts\OperatorContract {
        public function code(): string { return 'equals'; }
        public function evaluate(mixed $expected, mixed $actual): bool { return $expected === $actual; }
    };
    $registry->register($operator);
    $evaluator = new Evaluator($registry);

    // Context implementation decides what to return for unknown fields, typically null
    $context = new class implements RuleContext {
        public function value(string $key): mixed { return null; } // Unknown fields return null
    };

    $condition = new FieldCondition('unknown_field', 'equals', 'some_value');
    
    // Should evaluate to false safely because null !== 'some_value'
    $result = $evaluator->evaluate($condition, $context);
    expect($result)->toBeFalse();
});
