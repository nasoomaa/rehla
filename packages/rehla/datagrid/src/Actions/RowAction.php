<?php

namespace Rehla\DataGrid\Actions;

class RowAction
{
    public function __construct(
        protected string $id
    ) {}

    public function id(): string
    {
        return $this->id;
    }
}
