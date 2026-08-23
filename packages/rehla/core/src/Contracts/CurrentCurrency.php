<?php

namespace Rehla\Core\Contracts;

interface CurrentCurrency
{
    /**
     * @return string ISO 4217 code
     */
    public function code(): string;

    public function precision(): int;
}
