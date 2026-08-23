<x-dashboard::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('dashboard::app.settings.channels.create.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.settings.channels.create.before') !!}

    <x-dashboard::form
        action="{{ route('admin.settings.channels.store') }}"
        enctype="multipart/form-data"
    >

        {!! view_render_event('admin.settings.channels.create.create_form_controls.before') !!}

        <div class="flex items-center justify-between">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.settings.channels.create.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.settings.channels.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('dashboard::app.settings.channels.create.cancel')
                </a>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('dashboard::app.settings.channels.create.save-btn')
                </button>
            </div>
        </div>

        <!-- Body Content -->
        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <!-- Left sub-component -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">

                {!! view_render_event('rehla.dashboard.settings.channels.create.card.general.before') !!}

                <!-- General Information -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('dashboard::app.settings.channels.create.general')
                    </p>

                    <!-- Code -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.create.code')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="code"
                            name="code"
                            rules="required"
                            :value="old('code')"
                            :label="trans('dashboard::app.settings.channels.create.code')"
                            :placeholder="trans('dashboard::app.settings.channels.create.code')"
                        />

                        <x-dashboard::form.control-group.error control-name="code" />
                    </x-dashboard::form.control-group>

                    <!-- Name -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.create.name')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="name"
                            name="name"
                            rules="required"
                            :value="old('name')"
                            :label="trans('dashboard::app.settings.channels.create.name')"
                            :placeholder="trans('dashboard::app.settings.channels.create.name')"
                        />

                        <x-dashboard::form.control-group.error control-name="name" />
                    </x-dashboard::form.control-group>

                    <!-- Description -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label>
                            @lang('dashboard::app.settings.channels.create.description')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="textarea"
                            id="description"
                            name="description"
                            :value="old('description')"
                            :label="trans('dashboard::app.settings.channels.create.description')"
                            :placeholder="trans('dashboard::app.settings.channels.create.description')"
                        />

                        <x-dashboard::form.control-group.error control-name="description" />
                    </x-dashboard::form.control-group>

                    <!-- Inventory Sources -->
                    <div class="mb-4">
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.create.inventory-sources')
                        </x-dashboard::form.control-group.label>

                        @foreach (app('Webkul\Inventory\Repositories\InventorySourceRepository')->findWhere(['status' => 1]) as $inventorySource)
                            <x-dashboard::form.control-group class="!mb-2 flex items-center gap-2.5">
                                <x-dashboard::form.control-group.control
                                    type="checkbox"
                                    :id="'inventory_sources_' . $inventorySource->id"
                                    name="inventory_sources[]"
                                    rules="required"
                                    :value="$inventorySource->id "
                                    :for="'inventory_sources_' . $inventorySource->id"
                                    :label="trans('dashboard::app.settings.channels.create.inventory-sources')"
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
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.create.root-category')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="select"
                            id="root_category_id"
                            name="root_category_id"
                            rules="required"
                            :value="old('root_category_id')"
                            :label="trans('dashboard::app.settings.channels.create.root-category')"
                        >
                            <!-- Default Option -->
                            <option value="">
                                @lang('dashboard::app.settings.channels.create.select-root-category')
                            </option>

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
                            @lang('dashboard::app.settings.channels.create.hostname')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="hostname"
                            name="hostname"
                            :value="old('hostname')"
                            :label="trans('dashboard::app.settings.channels.create.hostname')"
                            :placeholder="trans('dashboard::app.settings.channels.create.hostname-placeholder')"
                        />

                        <x-dashboard::form.control-group.error control-name="hostname" />
                    </x-dashboard::form.control-group>
                </div>

                {!! view_render_event('rehla.dashboard.settings.channels.create.card.general.after') !!}

                {!! view_render_event('rehla.dashboard.settings.channels.create.card.design.before') !!}

                <!-- Logo and Design -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('dashboard::app.settings.channels.create.design')
                    </p>

                    <!-- Theme Selector -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label>
                            @lang('dashboard::app.settings.channels.create.theme')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="select"
                            id="theme"
                            name="theme"
                            :value="config('themes.admin-default')"
                            :label="trans('dashboard::app.settings.channels.create.theme')"
                        >
                            @foreach (config('themes.shop') as $themeCode => $theme)
                                <option
                                    value="{{ $themeCode }}"
                                    {{ old('theme') == $themeCode ? 'selected' : '' }}
                                    v-pre
                                >
                                    {{ $theme['name'] }}
                                </option>
                            @endforeach
                        </x-dashboard::form.control-group.control>

                        <x-dashboard::form.control-group.error control-name="theme" />
                    </x-dashboard::form.control-group>

                    <div class="flex justify-between">
                        <!-- Logo -->
                        <div class="flex w-2/5 flex-col">
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.channels.create.logo')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::media.images
                                    name="logo"
                                    meta-name="logo_meta"
                                    enable-seo="true"
                                    width="110px"
                                    height="110px"
                                />
                            </x-dashboard::form.control-group>

                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                @lang('dashboard::app.settings.channels.create.logo-size')
                            </p>
                        </div>


                        <!-- Favicon -->
                        <div class="flex w-2/5 flex-col">
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.channels.create.favicon')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::media.images
                                    name="favicon"
                                    meta-name="favicon_meta"
                                    enable-seo="true"
                                    width="110px"
                                    height="110px"
                                />
                            </x-dashboard::form.control-group>

                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                @lang('dashboard::app.settings.channels.create.favicon-size')
                            </p>
                        </div>
                    </div>
                </div>

                {!! view_render_event('rehla.dashboard.settings.channels.create.card.design.after') !!}

                {!! view_render_event('rehla.dashboard.settings.channels.create.card.seo.before') !!}

                <!-- Home Page SEO -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('dashboard::app.settings.channels.create.seo')
                    </p>

                    <!-- SEO Title & Description Blade Component -->
                    <x-dashboard::seo
                        meta-title-field="meta_title"
                        url-key-field="hostname"
                        meta-description-field="meta_description"
                        url-type="host"
                    />

                    <!-- SEO Title -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.create.seo-title')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="meta_title"
                            name="seo_title"
                            rules="required"
                            :value="old('seo_title')"
                            :label="trans('dashboard::app.settings.channels.create.seo-title')"
                            :placeholder="trans('dashboard::app.settings.channels.create.seo-title')"
                        />

                        <x-dashboard::form.control-group.error control-name="seo_title" />
                    </x-dashboard::form.control-group>

                    <!-- SEO Keywords -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.create.seo-keywords')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="textarea"
                            id="seo_keywords"
                            name="seo_keywords"
                            rules="required"
                            :value="old('seo_keywords') "
                            :label="trans('dashboard::app.settings.channels.create.seo-keywords')"
                            :placeholder="trans('dashboard::app.settings.channels.create.seo-keywords')"
                        />

                        <x-dashboard::form.control-group.error control-name="seo_keywords" />
                    </x-dashboard::form.control-group>

                    <!-- SEO Description -->
                    <x-dashboard::form.control-group class="!mb-0">
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.channels.create.seo-description')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="textarea"
                            id="meta_description"
                            name="seo_description"
                            rules="required"
                            :value="old('seo_description')"
                            :label="trans('dashboard::app.settings.channels.create.seo-description')"
                            :placeholder="trans('dashboard::app.settings.channels.create.seo-description')"
                        />

                        <x-dashboard::form.control-group.error control-name="seo_description" />
                    </x-dashboard::form.control-group>
                </div>

                {!! view_render_event('rehla.dashboard.settings.channels.create.card.seo.after') !!}

            </div>

            <!-- Right sub-component -->
            <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">

                {!! view_render_event('rehla.dashboard.settings.channels.create.card.accordion.currencies_and_locales.before') !!}

                <!-- Currencies and Locales -->
                <x-dashboard::accordion>
                    <x-slot:header>
                        <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                            @lang('dashboard::app.settings.channels.create.currencies-and-locales')
                        </p>
                    </x-slot>

                    <x-slot:content>
                        <!-- Locale Checkboxes  -->
                        <div class="mb-4">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.channels.create.locales')
                            </x-dashboard::form.control-group.label>

                            @foreach (core()->getAllLocales() as $locale)
                                <x-dashboard::form.control-group class="!mb-2 flex items-center gap-2.5">
                                    <x-dashboard::form.control-group.control
                                        type="checkbox"
                                        :id="'locales_' . $locale->id"
                                        name="locales[]"
                                        rules="required"
                                        :value="$locale->id"
                                        :for="'locales_' . $locale->id"
                                        :label="trans('dashboard::app.settings.channels.create.locales')"
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
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.channels.create.default-locale')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="select"
                                id="default_locale_id"
                                name="default_locale_id"
                                rules="required"
                                :value="old('default_locale_id')"
                                :label="trans('dashboard::app.settings.channels.create.default-locale')"
                            >
                                <!-- Default Option -->
                                <option value="">
                                    @lang('dashboard::app.settings.channels.create.select-default-locale')
                                </option>

                                @foreach (core()->getAllLocales() as $locale)
                                    <option
                                        value="{{ $locale->id }}"
                                        {{ old('default_locale_id') == $locale->id ? 'selected' : '' }}
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
                                @lang('dashboard::app.settings.channels.create.currencies')
                            </x-dashboard::form.control-group.label>

                            @foreach (core()->getAllCurrencies() as $currency)
                                <x-dashboard::form.control-group class="!mb-2 flex items-center gap-2.5">
                                    <x-dashboard::form.control-group.control
                                        type="checkbox"
                                        :id="'currencies_' . $currency->id"
                                        name="currencies[]"
                                        rules="required"
                                        :value="$currency->id"
                                        :for="'currencies_' . $currency->id"
                                        :label="trans('dashboard::app.settings.channels.create.currencies')"
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
                                @lang('dashboard::app.settings.channels.create.default-currency')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="select"
                                id="base_currency_id"
                                name="base_currency_id"
                                rules="required"
                                :value="old('base_currency_id')"
                                :label="trans('dashboard::app.settings.channels.create.default-currency')"
                            >
                                <!-- Default Option -->
                                <option value="">
                                    @lang('dashboard::app.settings.channels.create.select-default-currency')
                                </option>

                                @foreach (core()->getAllCurrencies() as $currency)
                                    <option
                                        value="{{ $currency->id }}"
                                        {{ old('base_currency_id') == $currency->id ? 'selected' : '' }}
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

                {!! view_render_event('rehla.dashboard.settings.channels.create.card.accordion.currencies_and_locales.after') !!}

                {!! view_render_event('rehla.dashboard.settings.channels.create.card.accordion.settings.before') !!}

                <!-- settings -->
                <x-dashboard::accordion>
                    <x-slot:header>
                        <div class="flex items-center justify-between">
                            <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('dashboard::app.settings.channels.create.settings')
                            </p>
                        </div>
                    </x-slot>

                    <x-slot:content>
                        <!-- Maintenance Mode Text  -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.settings.channels.create.maintenance-mode-text')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                id="maintenance-mode-text"
                                name="maintenance_mode_text"
                                :value="old('maintenance_mode_text')"
                                :label="trans('dashboard::app.settings.channels.create.maintenance-mode-text')"
                                :placeholder="trans('dashboard::app.settings.channels.create.maintenance-mode-text')"
                            />

                            <x-dashboard::form.control-group.error control-name="maintenance_mode_text" />
                        </x-dashboard::form.control-group>

                        <!-- Allowed API's  -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="!text-gray-800 dark:!text-white">
                                @lang('dashboard::app.settings.channels.create.allowed-ips')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                id="allowed-ips"
                                name="allowed_ips"
                                :value="old('allowed_ips')"
                                :label="trans('dashboard::app.settings.channels.create.allowed-ips')"
                                :placeholder="trans('dashboard::app.settings.channels.create.allowed-ips')"
                            />

                            <x-dashboard::form.control-group.error control-name="allowed_ips" />
                        </x-dashboard::form.control-group>

                        <!-- Maintenance Mode Switcher -->
                        <x-dashboard::form.control-group class="!mb-0">
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.settings.channels.create.status')
                            </x-dashboard::form.control-group.label>
                            <x-dashboard::form.control-group.control
                                type="switch"
                                id="maintenance-mode-status"
                                name="is_maintenance_on"
                                :value="1"
                                :checked="false"
                            />

                            <x-dashboard::form.control-group.error control-name="is_maintenance_on" />
                        </x-dashboard::form.control-group>
                    </x-slot>
                </x-dashboard::accordion>

                {!! view_render_event('rehla.dashboard.settings.channels.create.card.accordion.settings.after') !!}

            </div>
        </div>

        {!! view_render_event('admin.settings.channels.create.create_form_controls.after') !!}

    </x-dashboard::form>

    {!! view_render_event('rehla.dashboard.settings.channels.create.after') !!}
</x-dashboard::layouts>
