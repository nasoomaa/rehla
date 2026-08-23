<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.marketing.communications.campaigns.index.title')
    </x-slot>

    <div class="flex justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('dashboard::app.marketing.communications.campaigns.index.title')
        </p>

        <div class="flex items-center gap-x-2.5">
            @if (bouncer()->hasPermission('marketing.communications.campaigns.create'))
                <a href="{{ route('admin.marketing.communications.campaigns.create') }}">
                    <div class="primary-button">
                        @lang('dashboard::app.marketing.communications.campaigns.index.create-btn')
                    </div>
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('rehla.dashboard.marketing.communications.campaigns.list.before') !!}

    <x-dashboard::datagrid :src="route('admin.marketing.communications.campaigns.index')" />

    {!! view_render_event('rehla.dashboard.marketing.communications.campaigns.list.after') !!}

</x-dashboard::layouts>
