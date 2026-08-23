<?php

namespace Rehla\DataGrid\Contracts;

interface ExporterContract
{
    /**
     * Export the query results.
     *
     * @param mixed $query
     */
    public function export($query): void;
}
