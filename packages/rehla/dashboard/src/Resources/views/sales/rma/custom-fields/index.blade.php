<x-dashboard::layouts>
    <!-- Title of the page -->
    <x-slot:title>
        @lang('dashboard::app.sales.rma.custom-field.index.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <!-- Title -->
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('dashboard::app.sales.rma.custom-field.index.title')
        </p>

        <!-- Create Button -->
        <div class="flex items-center gap-x-2.5">
            @if (bouncer()->hasPermission('sales.rma.custom-fields.create'))
                <a
                    class="primary-button"
                    href="{{ route('admin.sales.rma.custom-fields.create') }}"
                >
                    @lang('dashboard::app.sales.rma.custom-field.index.create-btn')
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('rehla.dashboard.catalog.rma.custom-field.list.before') !!}

    <x-dashboard::datagrid :src="route('admin.sales.rma.custom-fields.index')"/>

    {!! view_render_event('rehla.dashboard.catalog.rma.custom-field.list.after') !!}

</x-dashboard::layouts>