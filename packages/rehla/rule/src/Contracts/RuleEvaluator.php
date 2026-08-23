<?php

namespace Rehla\Rule\Contracts;

interface RuleEvaluator
{
    /**
     * Evaluate a root condition (which can be a group) against a context.
     */
    public function evaluate(ConditionContract $condition, RuleContext $context): bool;
}
