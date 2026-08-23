<?php

namespace Rehla\Rule\Results;

class RuleResult
{
    public function __construct(
        private bool $satisfied
    ) {}

    public function isSatisfied(): bool
    {
        return $this->satisfied;
    }
}
