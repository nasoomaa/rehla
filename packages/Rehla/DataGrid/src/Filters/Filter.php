<?php

namespace Rehla\DataGrid\Filters;

use Rehla\DataGrid\Contracts\FilterContract;

class Filter implements FilterContract
{
    public function __construct(
        protected string $id
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function apply($query, $value): void
    {
        // Default implementation
    }
}
