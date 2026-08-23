<?php

namespace Rehla\Rule\Contracts;

interface OperatorContract
{
    /**
     * Get the string representation of the operator (e.g. '=', '>', 'contains').
     *
     * @return string
     */
    public function code(): string;

    /**
     * Evaluate the operator against two values.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @return bool
     */
    public function evaluate(mixed $expected, mixed $actual): bool;
}
