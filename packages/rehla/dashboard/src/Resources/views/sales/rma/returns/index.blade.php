<x-dashboard::layouts>
    <!-- Title of the page -->
    <x-slot:title>
        @lang('dashboard::app.sales.rma.all-rma.index.title')
    </x-slot:title>

    <div class="flex items-center justify-between gap-16 max-sm:flex-wrap">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('dashboard::app.sales.rma.index.rma-title')
        </h1>

        <div class="flex items-center gap-x-2.5">
            @if (bouncer()->hasPermission('sales.rma.requests.create'))
                <a
                    href="{{ route('admin.sales.rma.requests.create') }}"
                    class="primary-button"
                >
                    @lang('dashboard::app.sales.rma.index.create-rma-title')
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('rehla.dashboard.rma.list.before') !!}

    <x-dashboard::datagrid src="{{ route('admin.sales.rma.requests.index') }}" />

    {!! view_render_event('rehla.dashboard.rma.list.after') !!}

</x-dashboard::layouts>
