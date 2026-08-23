<?php

namespace Rehla\Rule\Operators;

use InvalidArgumentException;
use Rehla\Rule\Contracts\OperatorContract;

class OperatorRegistry
{
    /** @var array<string, OperatorContract> */
    private array $operators = [];

    public function register(OperatorContract $operator): void
    {
        $this->operators[$operator->code()] = $operator;
    }

    public function get(string $code): OperatorContract
    {
        if (! isset($this->operators[$code])) {
            throw new InvalidArgumentException("Operator [{$code}] is not registered.");
        }

        return $this->operators[$code];
    }
}
