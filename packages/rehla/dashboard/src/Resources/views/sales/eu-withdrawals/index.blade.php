<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.eu_withdrawal.index.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="py-3 text-xl font-bold text-gray-800 dark:text-white">
            @lang('dashboard::app.eu_withdrawal.index.title')
        </p>

        <div class="flex items-center gap-x-2.5">
            <x-dashboard::datagrid.export src="{{ route('admin.sales.eu-withdrawals.index') }}" />
        </div>
    </div>

    {!! view_render_event('rehla.dashboard.sales.eu_withdrawals.index.datagrid.before') !!}

    <x-dashboard::datagrid :src="route('admin.sales.eu-withdrawals.index')" />

    {!! view_render_event('rehla.dashboard.sales.eu_withdrawals.index.datagrid.after') !!}
</x-dashboard::layouts>
