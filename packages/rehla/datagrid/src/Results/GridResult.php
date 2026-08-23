<?php

namespace Rehla\DataGrid\Results;

class GridResult
{
    public function __construct(
        protected iterable $data
    ) {}

    public function data(): iterable
    {
        return $this->data;
    }
}
