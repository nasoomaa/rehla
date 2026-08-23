<?php

namespace Rehla\DataGrid\Query;

class GridQuery
{
    public function __construct(
        protected array $parameters = []
    ) {}

    public function parameters(): array
    {
        return $this->parameters;
    }
}
