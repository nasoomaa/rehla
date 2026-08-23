<?php

namespace Rehla\Rule;

use Rehla\Rule\Conditions\ConditionGroup;
use Rehla\Rule\Conditions\FieldCondition;
use Rehla\Rule\Contracts\ConditionContract;
use Rehla\Rule\Contracts\RuleContext;
use Rehla\Rule\Contracts\RuleEvaluator as RuleEvaluatorContract;
use Rehla\Rule\Operators\OperatorRegistry;
use Rehla\Rule\Results\RuleResult;

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
            $conditions = $condition->getConditions();

            if (empty($conditions)) {
                return new RuleResult($condition->isAll() ? true : false);
            }

            foreach ($conditions as $childCondition) {
                $childResult = $this->evaluateResult($childCondition, $context);

                if ($condition->isAll() && ! $childResult->isSatisfied()) {
                    return new RuleResult(false);
                }

                if (! $condition->isAll() && $childResult->isSatisfied()) {
                    return new RuleResult(true);
                }
            }

            return new RuleResult($condition->isAll() ? true : false);
        }

        return new RuleResult(false);
    }
}
