<?php

namespace Rehla\DataGrid\Contracts;

interface FilterContract
{
    /**
     * Apply the filter to the query builder.
     *
     * @param  mixed  $query
     * @param  mixed  $value
     */
    public function apply($query, $value): void;
}
