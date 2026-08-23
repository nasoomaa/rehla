<?php

namespace Rehla\DataGrid\Contracts;

interface DataGridContract
{
    /**
     * Get the unique server-registered grid identity.
     */
    public function identity(): string;

    /**
     * Define the columns available in this grid.
     */
    public function columns(): array;

    /**
     * Define the filters available in this grid.
     */
    public function filters(): array;

    /**
     * Define the mass actions available in this grid.
     */
    public function massActions(): array;
}
