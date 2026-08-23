<x-dashboard::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('dashboard::app.settings.roles.index.title')
    </x-slot>

    <div class="flex items-center justify-between">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('dashboard::app.settings.roles.index.title')
        </p>
        
        <div class="flex items-center gap-x-2.5">
            <!-- Add Role Button -->
            @if (bouncer()->hasPermission('settings.roles.create')) 
                <a 
                    href="{{ route('admin.settings.roles.create') }}"
                    class="primary-button"
                >
                    @lang('dashboard::app.settings.roles.index.create-btn')
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('rehla.dashboard.settings.roles.list.before') !!}
    
    <x-dashboard::datagrid :src="route('admin.settings.roles.index')" />

    {!! view_render_event('rehla.dashboard.settings.roles.list.after') !!}

</x-dashboard::layouts>