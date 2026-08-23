<?php

namespace Rehla\Rule\Conditions;

use Rehla\Rule\Contracts\ConditionContract;
use Rehla\Rule\Contracts\RuleContext;

class ConditionGroup implements ConditionContract
{
    /**
     * @param ConditionContract[] $conditions
     * @param bool $all
     */
    public function __construct(
        private array $conditions = [],
        private bool $all = true
    ) {}

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function isAll(): bool
    {
        return $this->all;
    }

    public function evaluate(RuleContext $context): bool
    {
        return false;
    }
}
