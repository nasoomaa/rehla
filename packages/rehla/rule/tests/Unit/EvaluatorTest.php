<?php

use Rehla\Rule\Conditions\ConditionGroup;
use Rehla\Rule\Conditions\FieldCondition;
use Rehla\Rule\Contracts\OperatorContract;
use Rehla\Rule\Contracts\RuleContext;
use Rehla\Rule\Evaluator;
use Rehla\Rule\Operators\OperatorRegistry;

beforeEach(function () {
    $this->registry = new OperatorRegistry;
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
    $this->registry->register($operator);
    $this->evaluator = new Evaluator($this->registry);

    $this->context = new class implements RuleContext
    {
        public function value(string $key): mixed
        {
            return match ($key) {
                'role' => 'admin',
                'status' => 'active',
                'age' => 30,
                default => null,
            };
        }
    };
});

test('ALL condition group requires all child conditions to be satisfied', function () {
    $group = new ConditionGroup([
        new FieldCondition('role', 'equals', 'admin'),
        new FieldCondition('status', 'equals', 'active'),
    ], true);

    expect($this->evaluator->evaluate($group, $this->context))->toBeTrue();
});

test('ALL condition group fails if one condition fails', function () {
    $group = new ConditionGroup([
        new FieldCondition('role', 'equals', 'admin'),
        new FieldCondition('status', 'equals', 'inactive'),
    ], true);

    expect($this->evaluator->evaluate($group, $this->context))->toBeFalse();
});

test('ANY condition group requires at least one child condition to be satisfied', function () {
    $group = new ConditionGroup([
        new FieldCondition('role', 'equals', 'user'), // fails
        new FieldCondition('status', 'equals', 'active'), // passes
    ], false);

    expect($this->evaluator->evaluate($group, $this->context))->toBeTrue();
});

test('ANY condition group fails if all conditions fail', function () {
    $group = new ConditionGroup([
        new FieldCondition('role', 'equals', 'user'),
        new FieldCondition('status', 'equals', 'inactive'),
    ], false);

    expect($this->evaluator->evaluate($group, $this->context))->toBeFalse();
});

test('Nested condition groups work correctly', function () {
    // (role = admin AND status = active) OR (age = 30)
    $nestedGroup = new ConditionGroup([
        new FieldCondition('role', 'equals', 'admin'),
        new FieldCondition('status', 'equals', 'active'),
    ], true);

    $rootGroup = new ConditionGroup([
        new FieldCondition('age', 'equals', 25), // fails
        $nestedGroup, // passes
    ], false);

    expect($this->evaluator->evaluate($rootGroup, $this->context))->toBeTrue();
});

test('Empty ALL group returns true, empty ANY group returns false', function () {
    $allGroup = new ConditionGroup([], true);
    $anyGroup = new ConditionGroup([], false);

    expect($this->evaluator->evaluate($allGroup, $this->context))->toBeTrue()
        ->and($this->evaluator->evaluate($anyGroup, $this->context))->toBeFalse();
});
