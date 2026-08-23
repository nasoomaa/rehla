<?php

namespace Rehla\DataGrid\Columns;

class Column
{
    public function __construct(
        protected string $id
    ) {}

    public function id(): string
    {
        return $this->id;
    }
}
