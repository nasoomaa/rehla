<?php

namespace Rehla\DataGrid\Contracts;

interface ActionAuthorizer
{
    /**
     * Determine if the user is authorized to perform the action.
     */
    public function authorize(string $actionId, ?object $model = null): bool;
}
