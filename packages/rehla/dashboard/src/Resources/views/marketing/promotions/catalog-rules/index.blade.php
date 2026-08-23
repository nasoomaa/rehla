<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.marketing.promotions.catalog-rules.index.title')
    </x-slot>

    <div class="mt-3 flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('dashboard::app.marketing.promotions.catalog-rules.index.title')
        </p>

        <div class="flex items-center gap-x-2.5">
            @if (bouncer()->hasPermission('marketing.promotions.catalog_rules.create'))
                <a 
                    href="{{ route('admin.marketing.promotions.catalog_rules.create') }}"
                    class="primary-button"
                >
                    @lang('dashboard::app.marketing.promotions.catalog-rules.index.create-btn')
                </a>
            @endif
        </div>
    </div>
    
    {!! view_render_event('rehla.dashboard.marketing.promotions.catalog_rules.list.before') !!}

    <x-dashboard::datagrid :src="route('admin.marketing.promotions.catalog_rules.index')" />

    {!! view_render_event('rehla.dashboard.marketing.promotions.catalog_rules.list.after') !!}

</x-dashboard::layouts>