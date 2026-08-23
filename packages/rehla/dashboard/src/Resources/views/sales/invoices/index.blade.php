<x-dashboard::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('dashboard::app.sales.invoices.index.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="py-3 text-xl font-bold text-gray-800 dark:text-white">
            @lang('dashboard::app.sales.invoices.index.title')
        </p>

        <div class="flex items-center gap-x-2.5">
            <!-- Export Modal -->
            <x-dashboard::datagrid.export :src="route('admin.sales.invoices.index')" />
        </div>
    </div>

    <x-dashboard::datagrid :src="route('admin.sales.invoices.index')" />

</x-dashboard::layouts>
