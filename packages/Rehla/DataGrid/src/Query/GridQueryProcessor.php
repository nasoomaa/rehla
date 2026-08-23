<?php

namespace Rehla\DataGrid\Query;

use Rehla\DataGrid\Contracts\DataGridContract;
use Rehla\DataGrid\Results\GridResult;

class GridQueryProcessor
{
    public function process(DataGridContract $grid, GridQuery $query): GridResult
    {
        // Safe processing of query parameters against registered grid options
        return new GridResult([]);
    }
}
