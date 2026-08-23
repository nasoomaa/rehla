<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.cms.index.title')
    </x-slot>

    <div class="flex items-center justify-between">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('dashboard::app.cms.index.title')
        </p>

        <div class="flex items-center gap-x-2.5">
            <!-- Export Modal -->
            <x-dashboard::datagrid.export :src="route('admin.cms.index')" />

            <!-- Create New Pages Button -->
            @if (bouncer()->hasPermission('cms.create'))
                <a
                    href="{{ route('admin.cms.create') }}"
                    class="primary-button"
                >
                    @lang('dashboard::app.cms.index.create-btn')
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('rehla.dashboard.cms.pages.list.before') !!}

    <x-dashboard::datagrid :src="route('admin.cms.index')" />
    
    {!! view_render_event('rehla.dashboard.cms.pages.list.after') !!}

</x-dashboard::layouts>
