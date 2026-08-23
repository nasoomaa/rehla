<x-dashboard::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('dashboard::app.settings.channels.edit.title')
    </x-slot>

    @php
        $currentLocale = core()->getRequestedLocale();

        $seo = $channel->translate($currentLocale->code)['home_seo'] ?? [];
    @endphp

    {!! view_render_event('rehla.dashboard.settings.channels.edit.before', ['channel' => $channel]) !!}

    <!-- Channel Edit Form -->
    <x-dashboard::form
        :action="route('admin.settings.channels.update', ['id' => $channel->id, 'locale' => $currentLocale->code])"
        enctype="multipart/form-data"
    >
        @method('PUT')

        {!! view_render_event('rehla.dashboard.settings.channels.edit.edit_form_controls.before', ['channel' => $channel]) !!}

        <div class="flex items-center justify-between">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.settings.channels.edit.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <a
                    href="{{ route('admin.settings.channels.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('dashboard::app.settings.channels.edit.back-btn')
                </a>

                <button
                    type="submit"
                    class="primary-button"
                    aria-label="Submit"
                >
                    @lang('dashboard::app.settings.channels.edit.save-btn')
                </button>
            </div>
        </div>

        <!-- Locale Switcher -->
        <div class="mt-7 flex items-center justify-between gap-4 max-md:flex-wrap">
            <div class="flex items-center gap-x-1">
                <x-dashboard::dropdown
                    position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'left' : 'right' }}"
                    :class="core()->getAllLocales()->count() <= 1 ? 'hidden' : ''"
                >
                    <!-- Dropdown Toggler -->
                    <x-slot:toggle>
                        <button
                            type="button"
                            class="transparent-button px-1 py-1.5 hover:bg-gray-200 focus:bg-gray-200 dark:text-white dark:hover:bg-gray-800 dark:focus:bg-gray-800"
                        >
                            <span class="icon-language text-2xl"></span>

                            <span v-pre>{{ $currentLocale->name }}</span>

                            <span class="icon-sort-down text-2xl"></span>
                        </button>
                    </x-slot>

                    <!-- Dropdown Content -->
                    <x-slot:content class="!p-0">
                        @foreach (core()->getAllLocales() as $locale)
                            <a
                                href="?{{ Arr::query(['locale' => $locale->code]) }}"
                                class="flex gap-2.5 px-5 py-2 text-base cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-950 dark:text-white {{ $locale->code == $currentLocale->code ? 'bg-gray-100 dark:bg-gray-950' : '' }}"
                                v-pre
                            >
                                {{ $locale->name }}
                            </a>
                        @endforeach
                    </x-slot>
                </x-dashboard::dropdown>
            </div>
        </div>

        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <!-- Left Component -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">

                {!! view_render_event('rehla.dashboard.settings.channels.edit.card.general.before', ['channel' => $channel]) !!}

                <!-- General Information -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('dashboard::app.settings.channels.edit.general')
                    </p>

                    <!-- Code -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.edit.code')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="code"
                            name="code"
                            rules="required"
                            :value="old('code') ?? $channel->code"
                            :label="trans('dashboard::app.settings.channels.edit.code')"
                            :placeholder="trans('dashboard::app.settings.channels.edit.code')"
                            disabled="disabled"
                        />

                        <input
                            type="hidden"
                            name="code"
                            value="{{ $channel->code }}"
                        />

                        <x-dashboard::form.control-group.error control-name="code" />
                    </x-dashboard::form.control-group>

                    <!-- Name -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.edit.name')

                            <span
                                class="rounded border border-gray-200 bg-gray-100 px-1 py-0.5 text-[10px] font-semibold leading-normal text-gray-600"
                                v-pre
                            >
                                {{ $currentLocale->name }}
                            </span>
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            :id="$currentLocale->code . '[name]'"
                            :name="$currentLocale->code . '[name]'"
                            rules="required"
                            :value="old($currentLocale->code)['name'] ?? ($channel->translate($currentLocale->code)['name'] ?? '')"
                            :label="trans('dashboard::app.settings.channels.edit.name')"
                            :placeholder="trans('dashboard::app.settings.channels.edit.name')"
                        />

                        <x-dashboard::form.control-group.error :control-name="$currentLocale->code . '.name'" />
                    </x-dashboard::form.control-group>

                    <!-- Description -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label>
                            @lang('dashboard::app.settings.channels.edit.description')

                            <span
                                class="rounded border border-gray-200 bg-gray-100 px-1 py-0.5 text-[10px] font-semibold leading-normal text-gray-600"
                                v-pre
                            >
                                {{ $currentLocale->name }}
                            </span>
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="textarea"
                            :id="$currentLocale->code . '[description]'"
                            :name="$currentLocale->code . '[description]'"
                            :value="old($currentLocale->code)['description'] ?? ($channel->translate($currentLocale->code)['description'] ?? '')"
                            :label="trans('dashboard::app.settings.channels.edit.description')"
                            :placeholder="trans('dashboard::app.settings.channels.edit.description')"
                        />

                        <x-dashboard::form.control-group.error :control-name="$currentLocale->code . '.description'" />
                    </x-dashboard::form.control-group>

                    <!-- Inventory Sources -->
                    <div class="mb-4">
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.edit.inventory-sources')
                        </x-dashboard::form.control-group.label>

                        @foreach (app('Webkul\Inventory\Repositories\InventorySourceRepository')->findWhere(['status' => 1]) as $inventorySource)
                            <x-dashboard::form.control-group class="!mb-2 flex items-center gap-2.5">
                                <x-dashboard::form.control-group.control
                                    type="checkbox"
                                    :id="'inventory_sources_' . $inventorySource->id"
                                    name="inventory_sources[]"
                                    rules="required"
                                    :value="$inventorySource->id"
                                    :for="'inventory_sources_' . $inventorySource->id"
                                    :label="trans('dashboard::app.settings.channels.edit.inventory-sources')"
                                    :checked="in_array($inventorySource->id, old('inventory_sources') ?? $channel->inventory_sources->pluck('id')->toArray())"
                                />

                                <label
                                    class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                    for="inventory_sources_{{ $inventorySource->id }}"
                                    v-pre
                                >
                                    {{ $inventorySource->name }}
                                </label>
                            </x-dashboard::form.control-group>
                        @endforeach

                        <x-dashboard::form.control-group.error control-name="inventory_sources[]" />
                    </div>

                    <!-- Root Category -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label>
                            @lang('dashboard::app.settings.channels.edit.root-category')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="select"
                            id="root_category_id"
                            name="root_category_id"
                            rules="required"
                            :value="old('root_category_id') ?? $channel->root_category_id"
                            :label="trans('dashboard::app.settings.channels.edit.root-category')"
                        >
                            @foreach (app('Webkul\Category\Repositories\CategoryRepository')->getRootCategories() as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ old('root_category_id') == $category->id ? 'selected' : '' }}
                                    v-pre
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-dashboard::form.control-group.control>

                        <x-dashboard::form.control-group.error control-name="root_category_id" />
                    </x-dashboard::form.control-group>

                    <!-- Host Name -->
                    <x-dashboard::form.control-group class="!mb-0">
                        <x-dashboard::form.control-group.label>
                            @lang('dashboard::app.settings.channels.edit.hostname')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="hostname"
                            name="hostname"
                            :value="old('hostname') ?? $channel->hostname"
                            :label="trans('dashboard::app.settings.channels.edit.hostname')"
                            :placeholder="trans('dashboard::app.settings.channels.edit.hostname-placeholder')"
                        />

                        <x-dashboard::form.control-group.error control-name="hostname" />
                    </x-dashboard::form.control-group>
                </div>

                {!! view_render_event('rehla.dashboard.settings.channels.edit.card.general.after', ['channel' => $channel]) !!}

                {!! view_render_event('rehla.dashboard.settings.channels.edit.card.design.before', ['channel' => $channel]) !!}

                <!-- Logo and Design -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('dashboard::app.settings.channels.edit.design')
                    </p>

                    <!--
                        Themes are switched from Appearance, so that the gallery can warn
                        about the customizations a switch leaves behind. Shown read only
                        here, with the value carried through the form untouched.
                    -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label>
                            @lang('dashboard::app.settings.channels.edit.theme')
                        </x-dashboard::form.control-group.label>

                        <div class="flex items-center gap-2.5">
                            <p class="text-sm text-gray-800 dark:text-white">
                                {{ config('themes.shop.'.$channel->theme.'.name') ?? $channel->theme ?? '—' }}
                            </p>

                            <a
                                href="{{ route('admin.appearance.themes.index') }}"
                                class="text-sm font-semibold text-blue-600 hover:underline"
                            >
                                @lang('dashboard::app.appearance.themes.index.title')
                            </a>
                        </div>

                        <input
                            type="hidden"
                            name="theme"
                            value="{{ old('theme') ?? $channel->theme }}"
                        />

                        <x-dashboard::form.control-group.error control-name="theme" />
                    </x-dashboard::form.control-group>

                    <div class="flex justify-between">
                        <!-- Logo -->
                        <div class="flex w-2/5 flex-col">
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.channels.edit.logo')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::media.images
                                    name="logo"
                                    meta-name="logo_meta"
                                    enable-seo="true"
                                    width="110px"
                                    height="110px"
                                    :uploaded-images="$channel->logo ? [[
                                        'id'        => 'logo',
                                        'url'       => $channel->logo_url,
                                        'file_name' => $channel->logo_file_name,
                                        'alt_text'  => $channel->logo_alt,
                                    ]] : []"
                                />
                            </x-dashboard::form.control-group>

                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                @lang('dashboard::app.settings.channels.edit.logo-size')
                            </p>
                        </div>

                        <!-- Favicon -->
                        <div class="flex w-2/5 flex-col">
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.channels.edit.favicon')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::media.images
                                    name="favicon"
                                    meta-name="favicon_meta"
                                    enable-seo="true"
                                    width="110px"
                                    height="110px"
                                    :uploaded-images="$channel->favicon ? [[
                                        'id'        => 'favicon',
                                        'url'       => $channel->favicon_url,
                                        'file_name' => $channel->favicon_file_name,
                                    ]] : []"
                                />
                            </x-dashboard::form.control-group>

                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                @lang('dashboard::app.settings.channels.edit.favicon-size')
                            </p>
                        </div>
                    </div>
                </div>

                {!! view_render_event('rehla.dashboard.settings.channels.edit.card.design.after', ['channel' => $channel]) !!}

                {!! view_render_event('rehla.dashboard.settings.channels.edit.card.seo.before', ['channel' => $channel]) !!}

                <!-- Home Page SEO -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('dashboard::app.settings.channels.edit.seo')
                    </p>

                    <!-- SEO Title & Description Blade Componnet -->
                    <x-dashboard::seo
                        meta-title-field="meta_title"
                        url-key-field="hostname"
                        meta-description-field="meta_description"
                        url-type="host"
                    />

                    <!-- Meta Title -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.edit.seo-title')

                            <span
                                class="rounded border border-gray-200 bg-gray-100 px-1 py-0.5 text-[10px] font-semibold leading-normal text-gray-600"
                                v-pre
                            >
                                {{ $currentLocale->name }}
                            </span>
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            :name="$currentLocale->code . '[seo_title]'"
                            :value="old($currentLocale->code)['seo_title'] ?? ($seo['meta_title'] ?? '')"
                            id="meta_title"
                            rules="required"
                            :label="trans('dashboard::app.settings.channels.edit.seo-title')"
                            :placeholder="trans('dashboard::app.settings.channels.edit.seo-title')"
                        />

                        <x-dashboard::form.control-group.error :control-name="$currentLocale->code . '.seo_title'" />
                    </x-dashboard::form.control-group>

                    <!-- Meta Keywords -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label>
                            @lang('dashboard::app.settings.channels.edit.seo-keywords')

                            <span
                                class="rounded border border-gray-200 bg-gray-100 px-1 py-0.5 text-[10px] font-semibold leading-normal text-gray-600"
                                v-pre
                            >
                                {{ $currentLocale->name }}
                            </span>
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="textarea"
                            id="seo_keywords"
                            :name="$currentLocale->code . '[seo_keywords]'"
                            :value="old($currentLocale->code)['seo_keywords'] ?? ($seo['meta_keywords'] ?? '')"
                            :label="trans('dashboard::app.settings.channels.edit.seo-keywords')"
                            :placeholder="trans('dashboard::app.settings.channels.edit.seo-keywords')"
                        />

                        <x-dashboard::form.control-group.error :control-name="$currentLocale->code . '.seo_keywords'" />
                    </x-dashboard::form.control-group>

                    <!-- Meta Description -->
                    <x-dashboard::form.control-group class="!mb-0">
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.edit.seo-description')

                            <span
                                class="rounded border border-gray-200 bg-gray-100 px-1 py-0.5 text-[10px] font-semibold leading-normal text-gray-600"
                                v-pre
                            >
                                {{ $currentLocale->name }}
                            </span>
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="textarea"
                            id="meta_description"
                            :name="$currentLocale->code . '[seo_description]'"
                            rules="required"
                            :value="old($currentLocale->code)['seo_description'] ?? ($seo['meta_description'] ?? '')"
                            :label="trans('dashboard::app.settings.channels.edit.seo-description')"
                            :placeholder="trans('dashboard::app.settings.channels.edit.seo-description')"
                        />

                        <x-dashboard::form.control-group.error :control-name="$currentLocale->code . '.seo_description'" />
                    </x-dashboard::form.control-group>
                </div>

                {!! view_render_event('rehla.dashboard.settings.channels.edit.card.seo.after', ['channel' => $channel]) !!}

            </div>

            <!-- Right Component -->
            <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">

                {!! view_render_event('rehla.dashboard.settings.channels.edit.card.accordion.currencies_and_locales.before', ['channel' => $channel]) !!}

                <!-- Currencies and Locale -->
                <x-dashboard::accordion>
                    <x-slot:header>
                        <div class="flex items-center justify-between">
                            <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('dashboard::app.settings.channels.edit.currencies-and-locales')
                            </p>
                        </div>
                    </x-slot>

                    <x-slot:content>
                        <!-- Locales Checkboxes -->
                        <div class="mb-4">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.channels.edit.locales')
                            </x-dashboard::form.control-group.label>

                            @php $selectedLocalesId = old('locales') ?? $channel->locales->pluck('id')->toArray(); @endphp

                            @foreach (core()->getAllLocales() as $locale)
                                <x-dashboard::form.control-group class="!mb-2 flex items-center gap-2.5">
                                    <x-dashboard::form.control-group.control
                                        type="checkbox"
                                        :id="'locales_' . $locale->id"
                                        name="locales[]"
                                        rules="required"
                                        :value="$locale->id"
                                        :for="'locales_' . $locale->id"
                                        :label="trans('dashboard::app.settings.channels.edit.locales')"
                                        :checked="in_array($locale->id, $selectedLocalesId)"
                                    />

                                    <label
                                        class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                        for="locales_{{ $locale->id }}"
                                        v-pre
                                    >
                                        {{ $locale->name }}
                                    </label>
                                </x-dashboard::form.control-group>
                            @endforeach

                            <x-dashboard::form.control-group.error control-name="locales[]" />
                        </div>

                        <!-- Default Locale Selector -->
                        <x-dashboard::form.control-group class="mb-4">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.channels.edit.default-locale')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="select"
                                id="default_locale_id"
                                name="default_locale_id"
                                rules="required"
                                :value="old('default_locale_id') ?? $channel->default_locale_id"
                                :label="trans('dashboard::app.settings.channels.edit.default-locale')"
                            >
                                @foreach (core()->getAllLocales() as $locale)
                                    <option
                                        value="{{ $locale->id }}"
                                        v-pre
                                    >
                                        {{ $locale->name }}
                                    </option>
                                @endforeach
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="default_locale_id" />
                        </x-dashboard::form.control-group>

                        <!-- Currencies Checkboxes -->
                        <div class="mb-4">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.channels.edit.currencies')
                            </x-dashboard::form.control-group.label>

                            @php $selectedCurrenciesId = old('currencies') ?: $channel->currencies->pluck('id')->toArray(); @endphp

                            @foreach (core()->getAllCurrencies() as $currency)
                                <x-dashboard::form.control-group class="!mb-2 flex items-center gap-2.5">
                                    <x-dashboard::form.control-group.control
                                        type="checkbox"
                                        :id="'currencies_' . $currency->id"
                                        name="currencies[]"
                                        rules="required"
                                        :value="$currency->id"
                                        :for="'currencies_' . $currency->id"
                                        :label="trans('dashboard::app.settings.channels.edit.currencies')"
                                        :checked="in_array($currency->id, $selectedCurrenciesId)"
                                    />

                                    <label
                                        class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                        for="currencies_{{ $currency->id }}"
                                        v-pre
                                    >
                                        {{ $currency->name }}
                                    </label>
                                </x-dashboard::form.control-group>
                            @endforeach

                            <x-dashboard::form.control-group.error control-name="currencies[]" />
                        </div>

                        <!-- Default Currency Selector -->
                        <x-dashboard::form.control-group class="!mb-0">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.channels.edit.default-currency')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="select"
                                id="base_currency_id"
                                name="base_currency_id"
                                rules="required"
                                :value="old('base_currency_id') ?? $channel->base_currency_id"
                                :label="trans('dashboard::app.settings.channels.edit.default-currency')"
                            >
                                @foreach (core()->getAllCurrencies() as $currency)
                                    <option
                                        value="{{ $currency->id }}"
                                        v-pre
                                    >
                                        {{ $currency->name }}
                                    </option>
                                @endforeach
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="base_currency_id" />
                        </x-dashboard::form.control-group>
                    </x-slot>
                </x-dashboard::accordion>

                {!! view_render_event('rehla.dashboard.settings.channels.edit.card.accordion.currencies_and_locales.after', ['channel' => $channel]) !!}

                {!! view_render_event('rehla.dashboard.settings.channels.edit.card.accordion.settings.before', ['channel' => $channel]) !!}

                <!-- Maintenance Mode -->
                <x-dashboard::accordion>
                    <x-slot:header>
                        <div class="flex items-center justify-between">
                            <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('dashboard::app.settings.channels.edit.maintenance-mode')
                            </p>
                        </div>
                    </x-slot>

                    <x-slot:content>
                        <!-- Maintenance Mode Text -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.settings.channels.edit.maintenance-mode-text')

                                <span
                                    class="rounded border border-gray-200 bg-gray-100 px-1 py-0.5 text-[10px] font-semibold leading-normal text-gray-600"
                                    v-pre
                                >
                                    {{ $currentLocale->name }}
                                </span>
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                id="maintenance-mode-text"
                                :name="$currentLocale->code . '[maintenance_mode_text]'"
                                :value="old($currentLocale->code)['maintenance_mode_text'] ?? ($channel->translate($currentLocale->code)['maintenance_mode_text'] ?? '')"
                                :label="trans('dashboard::app.settings.channels.edit.maintenance-mode-text')"
                                :placeholder="trans('dashboard::app.settings.channels.edit.maintenance-mode-text')"
                            />

                            <x-dashboard::form.control-group.error :control-name="$currentLocale->code . '.maintenance_mode_text'" />
                        </x-dashboard::form.control-group>

                        <!-- Allowed API's -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="!text-gray-800 dark:!text-white">
                                @lang('dashboard::app.settings.channels.edit.allowed-ips')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                id="allowed-ips"
                                name="allowed_ips"
                                :value="old('allowed_ips') ?? $channel->allowed_ips"
                                :label="trans('dashboard::app.settings.channels.edit.allowed-ips')"
                                :placeholder="trans('dashboard::app.settings.channels.edit.allowed-ips')"
                            />

                            <x-dashboard::form.control-group.error control-name="allowed_ips" />
                        </x-dashboard::form.control-group>

                        <!-- Maintenance Mode Switcher -->
                        <x-dashboard::form.control-group class="!mb-0">
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.settings.channels.edit.status')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="switch"
                                name="is_maintenance_on"
                                :value="1"
                                :label="trans('dashboard::app.settings.channels.edit.status')"
                                :checked="(boolean) $channel->is_maintenance_on"
                            />

                            <x-dashboard::form.control-group.error control-name="is_maintenance_on" />
                        </x-dashboard::form.control-group>
                    </x-slot>
                </x-dashboard::accordion>

                {!! view_render_event('rehla.dashboard.settings.channels.edit.card.accordion.settings.after', ['channel' => $channel]) !!}

            </div>
        </div>

        {!! view_render_event('rehla.dashboard.settings.channels.edit.edit_form_controls.after', ['channel' => $channel]) !!}

    </x-dashboard::form>

    {!! view_render_event('rehla.dashboard.settings.channels.edit.after', ['channel' => $channel]) !!}

</x-dashboard::layouts>
