<?php

namespace Rehla\DataGrid\Query;

use Rehla\DataGrid\Contracts\DataGridContract;
use Rehla\DataGrid\Results\GridResult;

class GridQueryProcessor
{
    public function process(DataGridContract $grid, GridQuery $query): GridResult
    {
        $parameters = $query->parameters();

        // 1. Clamp page size
        $perPage = (int) ($parameters['per_page'] ?? 15);
        if ($perPage > 100) {
            $perPage = 100;
        }

        // 2. Reject unregistered filters
        if (isset($parameters['filters']) && is_array($parameters['filters'])) {
            $registeredFilters = array_map(fn ($f) => clone $f, $grid->filters()); // just to ensure types, but actually we need to get their IDs

            // let's build a map of allowed filter IDs
            $allowedFilterIds = [];
            foreach ($grid->filters() as $filter) {
                // assume Filter has an id() method, although the contract didn't enforce it yet.
                // It's in the Filter class implementation, but let's just assume it has id() if it's a Rehla\DataGrid\Filters\Filter.
                if (method_exists($filter, 'id')) {
                    $allowedFilterIds[] = $filter->id();
                }
            }

            foreach (array_keys($parameters['filters']) as $filterId) {
                if (! in_array($filterId, $allowedFilterIds, true)) {
                    throw new \InvalidArgumentException("Unregistered filter: {$filterId}");
                }
            }
        }

        // 3. Reject unregistered sorts
        if (isset($parameters['sort'])) {
            $sortField = $parameters['sort'];

            $allowedColumnIds = [];
            foreach ($grid->columns() as $column) {
                if (method_exists($column, 'id')) {
                    $allowedColumnIds[] = $column->id();
                }
            }

            if (! in_array($sortField, $allowedColumnIds, true)) {
                throw new \InvalidArgumentException("Unregistered sort column: {$sortField}");
            }
        }

        return new GridResult([]);
    }
}
