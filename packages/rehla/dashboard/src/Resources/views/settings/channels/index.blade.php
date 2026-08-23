<x-dashboard::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('dashboard::app.settings.channels.index.title')
    </x-slot>

    <div class="flex items-center justify-between">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('dashboard::app.settings.channels.index.title')
        </p>
        
        <div class="flex items-center gap-x-2.5">
            <!-- Create New Channel Button -->
            @if (bouncer()->hasPermission('settings.channels.create'))
                <a 
                    href="{{ route('admin.settings.channels.create') }}"
                    class="primary-button"
                >
                    @lang('dashboard::app.settings.channels.index.create-btn')
                </a>
            @endif
        </div>
    </div>

    {!! view_render_event('bagisto.settings.channels.list.before') !!}
    
    <x-dashboard::datagrid :src="route('admin.settings.channels.index')" />

    {!! view_render_event('bagisto.settings.channels.list.after') !!}

</x-dashboard::layouts>