<?php

namespace Rehla\Rule\Contracts;

interface ConditionContract
{
    /**
     * Evaluate the condition against the given context.
     */
    public function evaluate(RuleContext $context): bool;
}
