<?php

namespace Rehla\Rule\Contracts;

interface ConditionContract
{
    /**
     * Evaluate the condition against the given context.
     *
     * @param RuleContext $context
     * @return bool
     */
    public function evaluate(RuleContext $context): bool;
}
