<?php

namespace Rehla\DataGrid;

use Rehla\DataGrid\Contracts\DataGridContract;

class GridRegistry
{
    /**
     * @var array<string, DataGridContract>
     */
    protected array $grids = [];

    public function register(DataGridContract $grid): void
    {
        $this->grids[$grid->identity()] = $grid;
    }

    public function resolve(string $identity): ?DataGridContract
    {
        return $this->grids[$identity] ?? null;
    }
}
