<?php

namespace Rehla\DataGrid;

use Rehla\DataGrid\Contracts\DataGridContract;

class DataGrid implements DataGridContract
{
    public function __construct(
        protected string $identity,
        protected array $columns = [],
        protected array $filters = [],
        protected array $massActions = []
    ) {}

    public function identity(): string
    {
        return $this->identity;
    }

    public function columns(): array
    {
        return $this->columns;
    }

    public function filters(): array
    {
        return $this->filters;
    }

    public function massActions(): array
    {
        return $this->massActions;
    }
}
