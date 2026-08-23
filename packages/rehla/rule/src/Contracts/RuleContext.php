<?php

namespace Rehla\Rule\Contracts;

interface RuleContext
{
    /**
     * Retrieve a value from the context by key.
     *
     * @param string $key
     * @return mixed
     */
    public function value(string $key): mixed;
}
