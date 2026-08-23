<?php

namespace Rehla\Dashboard\DataGrids\Settings;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Rehla\DataGrid\DataGrid;

class LocalesDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        return DB::table('locales')
            ->select(
                'id',
                'code',
                'name',
                'direction'
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
            'label' => trans('dashboard::app.settings.locales.index.datagrid.id'),
            'type' => 'integer',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'code',
            'label' => trans('dashboard::app.settings.locales.index.datagrid.code'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('dashboard::app.settings.locales.index.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'direction',
            'label' => trans('dashboard::app.settings.locales.index.datagrid.direction'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                [
                    'label' => trans('dashboard::app.settings.locales.index.datagrid.ltr'),
                    'value' => 'ltr',
                ],
                [
                    'label' => trans('dashboard::app.settings.locales.index.datagrid.rtl'),
                    'value' => 'rtl',
                ],
            ],
            'sortable' => true,
            'closure' => function ($value) {
                if ($value->direction == 'ltr') {
                    return trans('dashboard::app.settings.locales.index.datagrid.ltr');
                }

                return trans('dashboard::app.settings.locales.index.datagrid.rtl');
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
        if (bouncer()->hasPermission('settings.locales.edit')) {
            $this->addAction([
                'index' => 'edit',
                'icon' => 'icon-edit',
                'title' => trans('dashboard::app.settings.locales.index.datagrid.edit'),
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.settings.locales.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('settings.locales.delete')) {
            $this->addAction([
                'index' => 'delete',
                'icon' => 'icon-delete',
                'title' => trans('dashboard::app.settings.locales.index.datagrid.delete'),
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.settings.locales.delete', $row->id);
                },
            ]);
        }
    }
}
