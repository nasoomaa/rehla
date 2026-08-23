<?php

namespace Rehla\Rule\Contracts;

interface RuleContext
{
    /**
     * Retrieve a value from the context by key.
     */
    public function value(string $key): mixed;
}
