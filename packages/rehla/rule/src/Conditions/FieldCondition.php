<?php

namespace Rehla\Rule\Conditions;

use Rehla\Rule\Contracts\ConditionContract;
use Rehla\Rule\Contracts\RuleContext;

class FieldCondition implements ConditionContract
{
    public function __construct(
        private string $field,
        private string $operator,
        private mixed $value
    ) {}

    public function getField(): string
    {
        return $this->field;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function evaluate(RuleContext $context): bool
    {
        // Field condition evaluation depends on the operator,
        // which the Evaluator handles using the OperatorRegistry.
        // The ConditionContract doesn't strictly have to have evaluate() handle registry logic,
        // but since the spec states Evaluator evaluates, we might delegate.
        // Wait, the spec has RuleEvaluator interface which takes (ConditionContract, RuleContext).
        // Let's make it evaluate() return false by default here, as Evaluator actually does the logic.
        // Or we pass the registry?
        return false;
    }
}
