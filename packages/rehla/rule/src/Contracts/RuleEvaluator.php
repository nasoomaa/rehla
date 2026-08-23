<?php

namespace Rehla\Rule\Contracts;

interface RuleEvaluator
{
    /**
     * Evaluate a root condition (which can be a group) against a context.
     *
     * @param ConditionContract $condition
     * @param RuleContext $context
     * @return bool
     */
    public function evaluate(ConditionContract $condition, RuleContext $context): bool;
}
