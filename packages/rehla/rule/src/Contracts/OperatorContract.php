<?php

namespace Rehla\Rule\Contracts;

interface OperatorContract
{
    /**
     * Get the string representation of the operator (e.g. '=', '>', 'contains').
     */
    public function code(): string;

    /**
     * Evaluate the operator against two values.
     */
    public function evaluate(mixed $expected, mixed $actual): bool;
}
