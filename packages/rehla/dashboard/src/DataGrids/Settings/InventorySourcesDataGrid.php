<?php

namespace Rehla\Dashboard\DataGrids\Settings;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Rehla\DataGrid\DataGrid;

class InventorySourcesDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        return DB::table('inventory_sources')
            ->select(
                'id',
                'code',
                'name',
                'priority',
                'status'
            );
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('dashboard::app.settings.inventory-sources.index.datagrid.id'),
            'type' => 'integer',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'code',
            'label' => trans('dashboard::app.settings.inventory-sources.index.datagrid.code'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('dashboard::app.settings.inventory-sources.index.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'priority',
            'label' => trans('dashboard::app.settings.inventory-sources.index.datagrid.priority'),
            'type' => 'integer',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('dashboard::app.settings.inventory-sources.index.datagrid.status'),
            'type' => 'boolean',
            'searchable' => true,
            'filterable' => true,
            'filterable_options' => [
                [
                    'label' => trans('dashboard::app.settings.inventory-sources.index.datagrid.active'),
                    'value' => 1,
                ],
                [
                    'label' => trans('dashboard::app.settings.inventory-sources.index.datagrid.inactive'),
                    'value' => 0,
                ],
            ],
            'sortable' => true,
            'closure' => function ($value) {
                if ($value->status) {
                    return trans('dashboard::app.settings.inventory-sources.index.datagrid.active');
                }

                return trans('dashboard::app.settings.inventory-sources.index.datagrid.inactive');
            },
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        if (bouncer()->hasPermission('settings.inventory_sources.edit')) {
            $this->addAction([
                'icon' => 'icon-edit',
                'title' => trans('dashboard::app.settings.inventory-sources.index.datagrid.edit'),
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.settings.inventory_sources.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('settings.inventory_sources.delete')) {
            $this->addAction([
                'icon' => 'icon-delete',
                'title' => trans('dashboard::app.settings.inventory-sources.index.datagrid.delete'),
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.settings.inventory_sources.delete', $row->id);
                },
            ]);
        }
    }
}
