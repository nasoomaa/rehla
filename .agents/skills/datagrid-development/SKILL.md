---
name: datagrid-development
description: Use when building or changing a Rehla admin listing page — a DataGrid class with columns, search, filters, sorting, row actions, mass actions or export, and the controller and Blade view that render it. Trigger phrases include "datagrid", "admin listing", "add a column", "mass action", "prepareQueryBuilder", "listing page", "grid filter", "export grid".
requires: coding-standards
---

# DataGrid Development

An admin listing page is a `DataGrid` subclass plus three lines of wiring. The
engine (`packages/rehla/datagrid`) owns paging, search, filtering, sorting,
saved filters and export; the subclass supplies a query and describes its
columns.

## The four methods

`Rehla\DataGrid\DataGrid` declares two abstract methods and two optional hooks:

| Method | Required | Purpose |
|---|---|---|
| `prepareQueryBuilder()` | yes | Return a **query builder**, not a collection |
| `prepareColumns()` | yes | `addColumn([...])` per column |
| `prepareActions()` | no | Per-row actions, each ACL-gated |
| `prepareMassActions()` | no | Checkbox actions, each ACL-gated |

Tunable properties, overridden only when the default is wrong: `$primaryColumn`
(default `'id'`), `$sortColumn`, `$sortOrder` (`'desc'`), `$itemsPerPage` (10),
`$perPageOptions`.

## The shape

```php
<?php

namespace Rehla\Dashboard\DataGrids\Catalog;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Rehla\DataGrid\DataGrid;

class ServiceDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     */
    public function prepareQueryBuilder(): \Illuminate\Database\Query\Builder
    {
        return DB::table('services')
            ->select('id', 'name', 'status', 'price');
    }

    /**
     * Prepare columns.
     */
    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('dashboard::app.admin.catalog.services.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('dashboard::app.admin.catalog.services.datagrid.status'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    /**
     * Prepare actions.
     */
    public function prepareActions(): void
    {
        if (Gate::allows('catalog.services.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('dashboard::app.admin.catalog.services.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => route('admin.catalog.services.edit', $row->id),
            ]);
        }

        if (Gate::allows('catalog.services.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('dashboard::app.admin.catalog.services.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => route('admin.catalog.services.delete', $row->id),
            ]);
        }
    }
}
```

## Wiring

The controller serves JSON on an AJAX hit and the view otherwise — one route,
two responses:

```php
public function index(): mixed
{
    if (request()->ajax()) {
        return datagrid(ServiceDataGrid::class)->process();
    }

    return view('dashboard::catalog.services.index');
}
```

The Blade side is one tag pointing at that same route:

```blade
<x-dashboard::datagrid :src="route('admin.catalog.services.index')" />
```

`datagrid()` throws `InvalidDataGridException` unless the class extends
`Rehla\DataGrid\DataGrid`, so the class name is the only contract.

## Reference files

| File | Load when |
|---|---|
| [columns.md](columns.md) | Column types, search/filter/sort flags, dropdown options, closures, joins and `addFilter` |
| [actions.md](actions.md) | Row actions, mass actions, ACL gating, export |

## Non-negotiables

- **`prepareQueryBuilder()` returns a builder.** Calling `->get()`, `->paginate()`
  or mapping to a collection breaks paging, filtering and export, because the
  engine appends to the query you return.
- **The query builder is the one place `DB::` is expected.** Everywhere else in
  Rehla goes through a repository; a DataGrid is built on the query builder by
  design.
- **Every action and mass action is wrapped in `Gate::allows(...)`.**
  An ungated action renders for admins who cannot perform it, and the grid is
  the most common place this is forgotten.
- **Every `label` goes through `trans()`**, with the key added to all supported locales.
- **A joined query needs `addFilter()` for every aliased column** — see
  [columns.md](columns.md). Without it, filtering and sorting on that column
  produce an ambiguous-column SQL error.
- **Escape whatever a closure interpolates.** Cells render through `v-html`.
  The engine strips tags from raw values first, but not quotes — so a value
  placed inside an attribute can break out. See [columns.md](columns.md).

**REQUIRED SUB-SKILL:** Use change-verification before calling any change done.
