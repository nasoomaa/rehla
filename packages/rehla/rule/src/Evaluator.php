<?php

namespace Rehla\Rule;

use Rehla\Rule\Contracts\ConditionContract;
use Rehla\Rule\Contracts\RuleContext;
use Rehla\Rule\Contracts\RuleEvaluator as RuleEvaluatorContract;
use Rehla\Rule\Operators\OperatorRegistry;
use Rehla\Rule\Results\RuleResult;
use Rehla\Rule\Conditions\FieldCondition;
use Rehla\Rule\Conditions\ConditionGroup;

class Evaluator implements RuleEvaluatorContract
{
    public function __construct(
        private OperatorRegistry $operatorRegistry
    ) {}

    public function evaluate(ConditionContract $condition, RuleContext $context): bool
    {
        return $this->evaluateResult($condition, $context)->isSatisfied();
    }

    public function evaluateResult(ConditionContract $condition, RuleContext $context): RuleResult
    {
        if ($condition instanceof FieldCondition) {
            $operator = $this->operatorRegistry->get($condition->getOperator());
            $actual = $context->value($condition->getField());
            $satisfied = $operator->evaluate($condition->getValue(), $actual);
            
            return new RuleResult($satisfied);
        }

        if ($condition instanceof ConditionGroup) {
            $satisfied = $condition->isAll() ? true : false;
            // Basic stub for Task 3 vertical slice, fully implemented in Task 5.
            return new RuleResult($satisfied);
        }

        return new RuleResult(false);
    }
}
