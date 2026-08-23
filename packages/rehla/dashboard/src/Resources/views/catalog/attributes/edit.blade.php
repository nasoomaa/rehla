<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.catalog.attributes.edit.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.catalog.attributes.edit.before', ['attribute' => $attribute]) !!}

    <!-- Input Form -->
    <x-dashboard::form
        :action="route('admin.catalog.attributes.update', $attribute->id)"
        enctype="multipart/form-data"
        method="PUT"
    >
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.catalog.attributes.edit.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.catalog.attributes.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('dashboard::app.catalog.attributes.edit.back-btn')
                </a>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('dashboard::app.catalog.attributes.edit.save-btn')
                </button>
            </div>
        </div>

        <!-- Edit Attributes Vue Components -->
        <v-edit-attributes>
            <!-- Shimmer Effect -->
            <x-dashboard::shimmer.catalog.attributes />
        </v-edit-attributes>
    </x-dashboard::form>

    {!! view_render_event('rehla.dashboard.catalog.attributes.edit.after', ['attribute' => $attribute]) !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-edit-attributes-template"
        >
            <!-- Body Content -->
            <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
                <!-- Left Sub Component -->
                <div class="flex flex-1 flex-col gap-2 overflow-auto max-xl:flex-auto">

                    {!! view_render_event('rehla.dashboard.catalog.attributes.edit.card.label.before', ['attribute' => $attribute]) !!}

                    <!-- Label -->
                    <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                        <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                            @lang('dashboard::app.catalog.attributes.edit.label')
                        </p>

                        <!-- Admin Name -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.catalog.attributes.edit.admin')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="admin_name"
                                rules="required"
                                :value="old('admin_name') ?: $attribute->admin_name"
                                :label="trans('dashboard::app.catalog.attributes.edit.admin')"
                                :placeholder="trans('dashboard::app.catalog.attributes.edit.admin')"
                            />

                            <x-dashboard::form.control-group.error control-name="admin_name" />
                        </x-dashboard::form.control-group>

                        <!-- Locales Inputs -->
                        @foreach ($locales as $locale)
                            <x-dashboard::form.control-group class="last:!mb-0">
                                <x-dashboard::form.control-group.label v-pre>
                                    {{ $locale->name . ' (' . strtoupper($locale->code) . ')' }}
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    :name="$locale->code . '[name]'"
                                    :value="old($locale->code)['name'] ?? ($attribute->translate($locale->code)->name ?? '')"
                                    :placeholder="$locale->name"
                                />

                                <x-dashboard::form.control-group.error :control-name="$locale->code . '[name]'" />
                            </x-dashboard::form.control-group>
                        @endforeach
                    </div>

                    {!! view_render_event('rehla.dashboard.catalog.attributes.edit.card.label.after', ['attribute' => $attribute]) !!}

                    <!-- Options -->
                    <div
                        class="box-shadow rounded bg-white p-4 dark:bg-gray-900 {{ in_array($attribute->type, ['select', 'multiselect', 'checkbox']) ?: 'hidden' }}"
                        v-if="showSwatch"
                    >
                        <div class="mb-3 flex items-center justify-between">
                            <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('dashboard::app.catalog.attributes.edit.options')
                            </p>

                            <!-- Add Row Button -->
                            <div
                                class="secondary-button text-sm"
                                @click="$refs.addOptionsRow.toggle();swatchValue=''"
                            >
                                @lang('dashboard::app.catalog.attributes.edit.add-row')
                            </div>
                        </div>

                        <!-- Swatch Changer And Empty Field Section -->
                        <div
                            class="flex items-center gap-4 max-sm:flex-wrap"
                            v-if="attributeType == 'select'"
                        >
                            <!-- Input Options -->
                            <x-dashboard::form.control-group
                                class="mb-2.5 w-full"
                                v-if="this.showSwatch"
                            >
                                <x-dashboard::form.control-group.label for="swatchType">
                                    @lang('dashboard::app.catalog.attributes.edit.input-options')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="select"
                                    id="swatchType"
                                    name="swatch_type"
                                    v-model="swatchType"
                                    @change="showSwatch=true"
                                >
                                    @foreach ($swatchTypes as $swatchType)
                                        <option value="{{ $swatchType }}">
                                            @lang('dashboard::app.catalog.attributes.edit.option.' . $swatchType)
                                        </option>
                                    @endforeach
                                </x-dashboard::form.control-group.control>

                                <x-dashboard::form.control-group.error control-name="admin" />
                            </x-dashboard::form.control-group>

                            <!-- Checkbox -->
                            <div class="w-full">
                                <div class="!mb-0 flex w-max cursor-pointer select-none items-center gap-2.5">
                                    <input
                                        type="checkbox"
                                        name="empty_option"
                                        id="empty_option"
                                        for="empty_option"
                                        class="peer hidden"
                                        v-model="isNullOptionChecked"
                                        @click="$refs.addOptionsRow.toggle()"
                                    >

                                    <label
                                        for="empty_option"
                                        class="icon-uncheckbox peer-checked:icon-checked cursor-pointer rounded-md text-2xl peer-checked:text-blue-600"
                                    >
                                    </label>

                                    <label
                                        for="empty_option"
                                        class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                    >
                                        @lang('dashboard::app.catalog.attributes.edit.create-empty-option')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- For Attribute Options If Data Exist -->
                        <div class="mt-4 overflow-x-auto">
                            <template v-if="optionsData?.length">
                                @if (
                                    $attribute->type == 'select'
                                    || $attribute->type == 'multiselect'
                                    || $attribute->type == 'checkbox'
                                )
                                    <!-- Table Information -->
                                    <x-dashboard::table>
                                        <x-dashboard::table.thead class="text-sm font-medium dark:bg-gray-800">
                                            <x-dashboard::table.thead.tr>
                                                <!-- Draggable Icon -->
                                                <x-dashboard::table.th class="!p-0"></x-dashboard::table.th>

                                                <!-- Swatch Select -->
                                                <x-dashboard::table.th v-if="showSwatch && (swatchType == 'color' || swatchType == 'image')">
                                                    @lang('dashboard::app.catalog.attributes.edit.swatch')
                                                </x-dashboard::table.th>

                                                <!-- Admin Tables Heading -->
                                                <x-dashboard::table.th>
                                                    @lang('dashboard::app.catalog.attributes.edit.admin-name')
                                                </x-dashboard::table.th>

                                                <!-- Locales Tables Heading -->
                                                <x-dashboard::table.th 
                                                    v-for="locale in locales"
                                                    v-text="locale.name + ' (' + locale.code.toUpperCase() + ')' "
                                                >
                                                </x-dashboard::table.th>

                                                <!-- Action Tables Heading -->
                                                <x-dashboard::table.th></x-dashboard::table.th>
                                            </x-dashboard::table.thead.tr>
                                        </x-dashboard::table.thead>

                                        <!-- Draggable Component -->
                                        <draggable
                                            tag="tbody"
                                            ghost-class="draggable-ghost"
                                            handle=".icon-drag"
                                            v-bind="{animation: 200}"
                                            :list="optionsData"
                                            item-key="id"
                                        >
                                            <template #item="{ element, index }">
                                                <x-dashboard::table.thead.tr
                                                    class="hover:bg-gray-50 dark:hover:bg-gray-950"
                                                    v-show="! element.isDelete"
                                                >
                                                    <!-- Hidden Input -->
                                                    <input
                                                        type="hidden"
                                                        :name="'options[' + element.id + '][isNew]'"
                                                        :value="element.isNew"
                                                    >

                                                    <!-- Hidden Input -->
                                                    <input
                                                        type="hidden"
                                                        :name="'options[' + element.id + '][isDelete]'"
                                                        :value="element.isDelete"
                                                    >

                                                    <!-- Draggable Icon -->
                                                    <x-dashboard::table.td class="!px-0 text-center">
                                                        <i class="icon-drag cursor-grab text-xl transition-all group-hover:text-gray-700"></i>

                                                        <input
                                                            type="hidden"
                                                            :name="'options[' + element.id + '][sort_order]'"
                                                            :value="index"
                                                        />
                                                    </x-dashboard::table.td>

                                                    <!-- Swatch Type Image / Color -->
                                                    <x-dashboard::table.td v-if="showSwatch && (swatchType == 'color' || swatchType == 'image')">
                                                        <!-- Swatch Image -->
                                                        <div v-if="swatchType == 'image'">
                                                            <img
                                                                :src="element.swatch_value_url || '{{ bagisto_asset('images/product-placeholders/front.svg') }}'"
                                                                :alt="element.swatch_alt"
                                                                :ref="'image_' + element.id"
                                                                class="h-[50px] w-[50px]"
                                                            >

                                                            <input
                                                                type="file"
                                                                :name="'options[' + element.id + '][swatch_value]'"
                                                                class="hidden"
                                                                :ref="'imageInput_' + element.id"
                                                            />

                                                            <!-- Swatch Image SEO -->
                                                            <div class="mt-2 grid gap-1">
                                                                <input
                                                                    type="text"
                                                                    class="w-[160px] rounded-md border px-2 py-1.5 text-xs text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300"
                                                                    :name="'options[' + element.id + '][swatch_alt]'"
                                                                    :placeholder="@js(trans('dashboard::app.components.media.images.seo.alt-text'))"
                                                                    v-model="element.swatch_alt"
                                                                />

                                                                <input
                                                                    type="text"
                                                                    class="w-[160px] rounded-md border px-2 py-1.5 text-xs text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300"
                                                                    :name="'options[' + element.id + '][swatch_file_name]'"
                                                                    :placeholder="@js(trans('dashboard::app.components.media.images.seo.file-name'))"
                                                                    v-model="element.swatch_file_name"
                                                                />
                                                            </div>
                                                        </div>

                                                        <!-- Swatch Color -->
                                                        <div v-if="swatchType == 'color'">
                                                            <div
                                                                class="h-[25px] w-[25px] rounded-md border border-gray-200 dark:border-gray-800"
                                                                :style="{ background: element.swatch_value }"
                                                            >
                                                            </div>

                                                            <input
                                                                type="hidden"
                                                                :name="'options[' + element.id + '][swatch_value]'"
                                                                v-model="element.swatch_value"
                                                            />
                                                        </div>
                                                    </x-dashboard::table.td>

                                                    <!-- Admin -->
                                                    <x-dashboard::table.td>
                                                        <p class="dark:text-white">
                                                            @{{ element.admin_name }}
                                                        </p>

                                                        <input
                                                            type="hidden"
                                                            :name="'options[' + element.id + '][admin_name]'"
                                                            v-model="element.admin_name"
                                                        />
                                                    </x-dashboard::table.td>

                                                    <!-- Locales -->
                                                    <x-dashboard::table.td v-for="locale in locales">
                                                        <p class="dark:text-white">
                                                            @{{ element['locales'][locale.code] }}
                                                        </p>

                                                        <input
                                                            type="hidden"
                                                            :name="'options[' + element.id + '][' + locale.code + '][label]'"
                                                            v-model="element['locales'][locale.code]"
                                                        />
                                                    </x-dashboard::table.td>

                                                    <!-- Actions Button -->
                                                    <x-dashboard::table.td class="!px-0">
                                                        <span
                                                            class="icon-edit cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                                            @click="editOptions(element)"
                                                        >
                                                        </span>

                                                        <span
                                                            class="icon-delete cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-100 dark:hover:bg-gray-800 max-sm:place-self-center"
                                                            @click="removeOption(element.id)"
                                                        >
                                                        </span>
                                                    </x-dashboard::table.td>
                                                </x-dashboard::table.thead.tr>
                                            </template>
                                        </draggable>
                                    </x-dashboard::table>
                                @endif
                            </template>

                            <!-- For Empty Attribute Options -->
                            <template v-else>
                                <div class="grid justify-items-center gap-3.5 px-2.5 py-10">
                                    <!-- Attribute Option Image -->
                                    <img
                                        class="h-[120px] w-[120px] dark:mix-blend-exclusion dark:invert"
                                        src="{{ bagisto_asset('images/icon-add-product.svg') }}"
                                        alt="{{ trans('dashboard::app.catalog.attributes.edit.add-attribute-options') }}"
                                    >

                                    <!-- Add Attribute Options Information -->
                                    <div class="flex flex-col items-center gap-1.5">
                                        <p class="text-base font-semibold text-gray-400">
                                            @lang('dashboard::app.catalog.attributes.edit.add-attribute-options')
                                        </p>

                                        <p class="text-gray-400">
                                            @lang('dashboard::app.catalog.attributes.edit.add-options-info')
                                        </p>
                                    </div>

                                    <!-- Add Row Button -->
                                    <div
                                        class="secondary-button text-sm"
                                        @click="$refs.addOptionsRow.toggle()"
                                    >
                                        @lang('dashboard::app.catalog.attributes.edit.add-row')
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Right Sub Component -->
                <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
                    {!! view_render_event('rehla.dashboard.catalog.attributes.edit.card.accordion.general.before', ['attribute' => $attribute]) !!}

                    <!-- General -->
                    <x-dashboard::accordion>
                        <x-slot:header>
                            <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('dashboard::app.catalog.attributes.edit.general')
                            </p>
                        </x-slot>

                        <x-slot:content>
                            <!-- Attribute Code -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.catalog.attributes.edit.code')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    class="cursor-not-allowed"
                                    name="code"
                                    rules="required"
                                    :value="old('code') ?? $attribute->code"
                                    disabled="true"
                                    :label="trans('dashboard::app.catalog.attributes.edit.code')"
                                    :placeholder="trans('dashboard::app.catalog.attributes.edit.code')"
                                />

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="code"
                                    :value="$attribute->code"
                                />

                                <x-dashboard::form.control-group.error control-name="code" />
                            </x-dashboard::form.control-group>

                            <!-- Attribute Type -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.catalog.attributes.edit.type')
                                </x-dashboard::form.control-group.label>

                                @php
                                    $selectedOption = old('type') ?: $attribute->type;
                                @endphp

                                <x-dashboard::form.control-group.control
                                    type="select"
                                    id="type"
                                    class="cursor-not-allowed"
                                    name="type"
                                    rules="required"
                                    :value="$selectedOption"
                                    :disabled="(boolean) $selectedOption"
                                    :label="trans('dashboard::app.catalog.attributes.edit.type')"
                                >
                                    @foreach($attributeTypes as $attributeType)
                                        <option
                                            value="{{ $attributeType }}"
                                            {{ $selectedOption == $attributeType ? 'selected' : '' }}
                                        >
                                            @lang('dashboard::app.catalog.attributes.edit.'. $attributeType)
                                        </option>
                                    @endforeach
                                </x-dashboard::form.control-group.control>

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="type"
                                    :value="$attribute->type"
                                />

                                <x-dashboard::form.control-group.error control-name="type" />
                            </x-dashboard::form.control-group>

                            <!-- Textarea Switcher -->
                            @if($attribute->type == 'textarea')
                                <x-dashboard::form.control-group>
                                    <x-dashboard::form.control-group.label>
                                        @lang('dashboard::app.catalog.attributes.edit.enable-wysiwyg')
                                    </x-dashboard::form.control-group.label>

                                    <input
                                        type="hidden"
                                        name="enable_wysiwyg"
                                        value="0"
                                    />

                                    @php $selectedOption = old('enable_wysiwyg') ?: $attribute->enable_wysiwyg @endphp

                                    <x-dashboard::form.control-group.control
                                        type="switch"
                                        name="enable_wysiwyg"
                                        value="1"
                                        :label="trans('dashboard::app.catalog.attributes.edit.enable-wysiwyg')"
                                        :checked="(bool) $selectedOption"
                                    />
                                </x-dashboard::form.control-group>
                            @endif

                            <!-- Default Value -->
                            <x-dashboard::form.control-group
                                class="!mb-0"
                                v-if="canHaveDefaultValue"
                            >
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.catalog.attributes.edit.default-value')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="default_value"
                                    value="{{ old('default_value') ?: $attribute->default_value }}"
                                    :label="trans('dashboard::app.catalog.attributes.edit.default-value')"
                                />

                                <x-dashboard::form.control-group.error control-name="default_value" />
                            </x-dashboard::form.control-group>
                        </x-slot>
                    </x-dashboard::accordion>

                    {!! view_render_event('rehla.dashboard.catalog.attributes.edit.card.accordion.general.after', ['attribute' => $attribute]) !!}

                    {!! view_render_event('rehla.dashboard.catalog.attributes.edit.card.accordion.validations.before', ['attribute' => $attribute]) !!}

                    <!-- Validations -->
                    <x-dashboard::accordion>
                        <x-slot:header>
                            <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('dashboard::app.catalog.attributes.edit.validations')
                            </p>
                        </x-slot>

                        <x-slot:content>
                            <!-- Input Validation -->
                            @if($attribute->type == 'text')
                                <x-dashboard::form.control-group>
                                    <x-dashboard::form.control-group.label>
                                        @lang('dashboard::app.catalog.attributes.edit.input-validation')
                                    </x-dashboard::form.control-group.label>

                                        <x-dashboard::form.control-group.control
                                            type="select"
                                            class="cursor-not-allowed"
                                            name="validation"
                                            :value="$attribute->validation"
                                            disabled="disabled"
                                        >
                                            @foreach($validations as $validation)
                                                <option value="{{ $validation }}" {{ $attribute->validation == $validation ? 'selected' : '' }}>
                                                    @lang('dashboard::app.catalog.attributes.edit.' . $validation)
                                                </option>
                                            @endforeach
                                        </x-dashboard::form.control-group.control>
                                    </x-dashboard::form.control-group>
                                @endif

                                <!-- REGEX -->
                                @if($attribute->validation == "regex")
                                    <x-dashboard::form.control-group>
                                        <x-dashboard::form.control-group.label>
                                            @lang('dashboard::app.catalog.attributes.edit.regex')
                                        </x-dashboard::form.control-group.label>

                                        <x-dashboard::form.control-group.control
                                            type="text"
                                            class="cursor-not-allowed"
                                            id="regex"
                                            name="regex"
                                            :value="$attribute->regex"
                                            :label="trans('dashboard::app.catalog.attributes.edit.regex')"
                                            disabled="disabled"
                                        />

                                        <!-- Regex Info -->
                                        <p class="mt-2 text-xs font-medium text-gray-500 dark:text-gray-300">
                                            @lang('dashboard::app.catalog.attributes.edit.regex-info')
                                        </p>
                                    </x-dashboard::form.control-group>
                                @endif

                            <!-- Is Required -->
                            <x-dashboard::form.control-group class="!mb-2 flex select-none items-center gap-2.5">
                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="is_required"
                                    :value="(boolean) $selectedOption"
                                />

                                <x-dashboard::form.control-group.control
                                    type="checkbox"
                                    name="is_required"
                                    id="is_required"
                                    for="is_required"
                                    value="1"
                                    :checked="(boolean) (old('is_required') ?? $attribute->is_required)"
                                />

                                <label
                                    class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                    for="is_required"
                                >
                                    @lang('dashboard::app.catalog.attributes.edit.is-required')
                                </label>
                            </x-dashboard::form.control-group>

                            <!-- Is Unique -->
                            <x-dashboard::form.control-group class="!mb-0 flex select-none items-center gap-2.5">
                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="is_unique"
                                    :value="(boolean) (old('is_unique') ?? $attribute->is_unique)"
                                />

                                <x-dashboard::form.control-group.control
                                    type="checkbox"
                                    id="is_unique"
                                    name="is_unique"
                                    value="1"
                                    for="is_unique"
                                    :checked="(boolean) $attribute->is_unique"
                                    :disabled="(boolean) $attribute->is_unique"
                                />

                                <label
                                    class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                    for="is_unique"
                                >
                                    @lang('dashboard::app.catalog.attributes.edit.is-unique')
                                </label>
                            </x-dashboard::form.control-group>
                        </x-slot>
                    </x-dashboard::accordion>

                    {!! view_render_event('rehla.dashboard.catalog.attributes.edit.card.accordion.validations.after', ['attribute' => $attribute]) !!}

                    {!! view_render_event('rehla.dashboard.catalog.attributes.edit.card.accordion.configuration.before', ['attribute' => $attribute]) !!}

                    <!-- Configurations -->
                    <x-dashboard::accordion>
                        <x-slot:header>
                            <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('dashboard::app.catalog.attributes.edit.configuration')
                            </p>
                        </x-slot>

                        <x-slot:content>
                            <!-- Value Per Locale -->
                            <x-dashboard::form.control-group class="!mb-2 flex select-none items-center gap-2.5 opacity-70">
                                @php
                                    $valuePerLocale = old('value_per_locale') ?? $attribute->value_per_locale;
                                @endphp

                                <x-dashboard::form.control-group.control
                                    type="checkbox"
                                    id="value_per_locale"
                                    name="value_per_locale"
                                    value="1"
                                    :checked="(boolean) $valuePerLocale"
                                    :disabled="(boolean) $valuePerLocale"
                                />

                                <label
                                    class="cursor-not-allowed text-xs font-medium text-gray-600 dark:text-gray-300"
                                >
                                    @lang('dashboard::app.catalog.attributes.edit.value-per-locale')
                                </label>

                                <x-dashboard::catalog.attributes.flag-info
                                    :text="trans('dashboard::app.catalog.attributes.edit.info.value-per-locale')"
                                />

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="value_per_locale"
                                    :value="(boolean) $valuePerLocale"
                                />
                            </x-dashboard::form.control-group>

                            <!-- Value Per Channel -->
                            <x-dashboard::form.control-group class="!mb-2 flex select-none items-center gap-2.5 opacity-70">
                                @php
                                    $valuePerChannel = old('value_per_channel') ?? $attribute->value_per_channel;
                                @endphp

                                <x-dashboard::form.control-group.control
                                    type="checkbox"
                                    id="value_per_channel"
                                    name="value_per_channel"
                                    value="1"
                                    :checked="(boolean) $valuePerChannel"
                                    :disabled="(boolean) $valuePerChannel"
                                />

                                <label class="cursor-not-allowed text-xs font-medium text-gray-600 dark:text-gray-300">
                                    @lang('dashboard::app.catalog.attributes.edit.value-per-channel')
                                </label>

                                <x-dashboard::catalog.attributes.flag-info
                                    :text="trans('dashboard::app.catalog.attributes.edit.info.value-per-channel')"
                                />

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="value_per_channel"
                                    :value="(boolean) $valuePerChannel"
                                />
                            </x-dashboard::form.control-group>

                            <!-- Use In Layered -->
                            <x-dashboard::form.control-group
                                class="!mb-2 flex select-none items-center gap-2.5"
                                ::class="{ 'opacity-70' : ! isFilterable }"
                            >
                                @php
                                    $isFilterable = old('is_filterable') ?? $attribute->is_filterable;
                                @endphp

                                <x-dashboard::form.control-group.control
                                    type="checkbox"
                                    id="is_filterable"
                                    name="is_filterable"
                                    value="1"
                                    for="is_filterable"
                                    :checked="(boolean) $isFilterable"
                                    ::disabled="! isFilterable"
                                />

                                <label
                                    :class="`${isFilterable ? 'cursor-pointer' : 'cursor-not-allowed'} text-xs font-medium text-gray-600 dark:text-gray-300`"
                                    for="is_filterable"
                                >
                                    @lang('dashboard::app.catalog.attributes.edit.is-filterable')
                                </label>

                                <x-dashboard::catalog.attributes.flag-info
                                    :text="trans('dashboard::app.catalog.attributes.edit.info.is-filterable')"
                                />

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="is_filterable"
                                    :value="(boolean) $isFilterable"
                                />
                            </x-dashboard::form.control-group>

                            <!-- Use To Create Configurable Product -->
                            <x-dashboard::form.control-group
                                class="!mb-2 flex select-none items-center gap-2.5"
                                ::class="{ 'opacity-70' : ! isConfigurable }"
                            >
                                @php
                                    $isConfigurable = old('is_configurable') ?? $attribute->is_configurable;
                                @endphp

                                <x-dashboard::form.control-group.control
                                    type="checkbox"
                                    id="is_configurable"
                                    name="is_configurable"
                                    value="1"
                                    for="is_configurable"
                                    :checked="(boolean) $isConfigurable"
                                    ::disabled="! isConfigurable"
                                />

                                <label
                                    :class="`${isConfigurable ? 'cursor-pointer' : 'cursor-not-allowed'} text-xs font-medium text-gray-600 dark:text-gray-300`"
                                    for="is_configurable"
                                >
                                    @lang('dashboard::app.catalog.attributes.edit.is-configurable')
                                </label>

                                <x-dashboard::catalog.attributes.flag-info
                                    :text="trans('dashboard::app.catalog.attributes.edit.info.is-configurable')"
                                />

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="is_configurable"
                                    :value="(boolean) $isConfigurable"
                                />
                            </x-dashboard::form.control-group>

                            <!-- Visible On Product View Page On Front End -->
                            <x-dashboard::form.control-group class="!mb-2 flex select-none items-center gap-2.5">
                                @php
                                    $isVisibleOnFront = old('is_visible_on_front') ?? $attribute->is_visible_on_front;
                                @endphp

                                <x-dashboard::form.control-group.control
                                    type="checkbox"
                                    id="is_visible_on_front"
                                    name="is_visible_on_front"
                                    for="is_visible_on_front"
                                    value="1"
                                    :checked="(boolean) $isVisibleOnFront"
                                />

                                <label
                                    class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                    for="is_visible_on_front"
                                >
                                    @lang('dashboard::app.catalog.attributes.edit.is-visible-on-front')
                                </label>

                                <x-dashboard::catalog.attributes.flag-info
                                    :text="trans('dashboard::app.catalog.attributes.edit.info.is-visible-on-front')"
                                />

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="is_visible_on_front"
                                    :value="(boolean) $isVisibleOnFront"
                                />
                            </x-dashboard::form.control-group>

                            <!-- Attribute Is Comparable -->
                            <x-dashboard::form.control-group class="!mb-0 flex select-none items-center gap-2.5">
                                @php
                                    $isComparable = old('is_comparable') ?? $attribute->is_comparable
                                @endphp

                                <x-dashboard::form.control-group.control
                                    type="checkbox"
                                    id="is_comparable"
                                    name="is_comparable"
                                    value="1"
                                    for="is_comparable"
                                    :checked="(boolean) $isComparable"
                                />

                                <label
                                    class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                    for="is_comparable"
                                >
                                    @lang('dashboard::app.catalog.attributes.edit.is-comparable')
                                </label>

                                <x-dashboard::catalog.attributes.flag-info
                                    :text="trans('dashboard::app.catalog.attributes.edit.info.is-comparable')"
                                />

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="is_comparable"
                                    :value="(boolean) $isComparable"
                                />
                            </x-dashboard::form.control-group>
                        </x-slot>
                    </x-dashboard::accordion>

                    {!! view_render_event('rehla.dashboard.catalog.attributes.edit.card.accordion.configuration.configuration.after', ['attribute' => $attribute]) !!}
                </div>
            </div>

            <!-- Add Options Model Form -->
            <x-dashboard::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
                ref="modelForm"
            >
                <form
                    @submit.prevent="handleSubmit($event, storeOptions)"
                    enctype="multipart/form-data"
                    ref="editOptionsForm"
                >
                    <x-dashboard::modal
                        @toggle="listenModel"
                        ref="addOptionsRow"
                    >
                        <!-- Modal Header -->
                        <x-slot:header>
                            <p class="text-lg font-bold text-gray-800 dark:text-white">
                                @lang('dashboard::app.catalog.attributes.edit.add-option')
                            </p>
                        </x-slot>

                        <!-- Modal Content -->
                        <x-slot:content>
                            <div class="grid">
                                <!-- Image Input -->
                                <x-dashboard::form.control-group
                                    class="w-full"
                                    v-if="swatchType == 'image'"
                                >
                                    <x-dashboard::form.control-group.label>
                                        @lang('dashboard::app.catalog.attributes.edit.image')
                                    </x-dashboard::form.control-group.label>

                                    <div class="hidden">
                                        <x-dashboard::media.images
                                            name="swatch_value[]"
                                            ::uploaded-images='swatchValue.image'
                                        />
                                    </div>

                                    <v-media-images
                                        name="swatch_value"
                                        :uploaded-images='swatchValue.image'
                                    >
                                    </v-media-images>

                                    <x-dashboard::form.control-group.error control-name="swatch_value" />
                                </x-dashboard::form.control-group>

                                <!-- Color Input -->
                                <x-dashboard::form.control-group
                                    class="w-2/6"
                                    v-if="swatchType == 'color'"
                                >
                                    <x-dashboard::form.control-group.label>
                                        @lang('dashboard::app.catalog.attributes.edit.color')
                                    </x-dashboard::form.control-group.label>

                                    <x-dashboard::form.control-group.control
                                        type="color"
                                        name="swatch_value"
                                        :placeholder="trans('dashboard::app.catalog.attributes.edit.color')"
                                    />

                                    <x-dashboard::form.control-group.error control-name="swatch_value[]" />
                                </x-dashboard::form.control-group>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <!-- Hidden Input -->
                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="id"
                                />

                                <!-- Hidden Input -->
                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="isNew"
                                    ::value="optionIsNew"
                                />

                                <!-- Admin Input -->
                                <x-dashboard::form.control-group class="mb-2.5 w-full">
                                    <x-dashboard::form.control-group.label ::class="{ 'required' : ! isNullOptionChecked }">
                                        @lang('dashboard::app.catalog.attributes.edit.admin')
                                    </x-dashboard::form.control-group.label>

                                    <x-dashboard::form.control-group.control
                                        type="text"
                                        name="admin_name"
                                        ::rules="{ 'required' : ! isNullOptionChecked }"
                                        :label="trans('dashboard::app.catalog.attributes.edit.admin')"
                                        :placeholder="trans('dashboard::app.catalog.attributes.edit.admin')"
                                        ref="inputAdmin"
                                    />

                                    <x-dashboard::form.control-group.error control-name="admin_name" />
                                </x-dashboard::form.control-group>

                                <!-- Locales Input -->
                                @foreach ($locales as $locale)
                                    <x-dashboard::form.control-group class="mb-2.5 w-full">
                                        <x-dashboard::form.control-group.label 
                                            ::class="{ '{{ core()->getDefaultLocaleCodeFromDefaultChannel() == $locale->code ? 'required' : '' }}' : ! isNullOptionChecked }"
                                            v-pre
                                        >
                                            {{ $locale->name }} ({{ strtoupper($locale->code) }})
                                        </x-dashboard::form.control-group.label>

                                        <x-dashboard::form.control-group.control
                                            type="text"
                                            name="locales.{{ $locale->code }}"
                                            ::rules="{ '{{ core()->getDefaultLocaleCodeFromDefaultChannel() == $locale->code ? 'required' : '' }}' : ! isNullOptionChecked }"
                                            :label="$locale->name"
                                            :placeholder="$locale->name"
                                        />

                                        <x-dashboard::form.control-group.error control-name="locales.{{ $locale->code }}" />
                                    </x-dashboard::form.control-group>
                                @endforeach
                            </div>
                        </x-slot>

                        <!-- Modal Footer -->
                        <x-slot:footer>
                            <!-- Save Button -->
                            <x-dashboard::button
                                button-type="button"
                                class="primary-button"
                                :title="trans('dashboard::app.catalog.attributes.edit.option.save-btn')"
                            />
                        </x-slot>
                    </x-dashboard::modal>
                </form>
            </x-dashboard::form>
        </script>

        <script type="module">
            app.component('v-edit-attributes', {
                template: '#v-edit-attributes-template',

                data() {
                    return {
                        showSwatch: {{ in_array($attribute->type, ['select', 'checkbox', 'multiselect']) ? 'true' : 'false' }},

                        attributeCode: "{{ $attribute->code }}",

                        attributeType: "{{ $attribute->type }}",

                        swatchType: "{{ $attribute->swatch_type == '' ? 'dropdown' : $attribute->swatch_type }}",

                        isNullOptionChecked: false,

                        swatchValue: [
                            {
                                image: [],
                            }
                        ],

                        optionsData: [],

                        locales: @json($locales),

                        optionIsNew: true,

                        optionId: 0,
                    }
                },

                computed: {
                    isFilterable() {
                        return this.attributeType == 'checkbox'
                            || this.attributeType == 'select'
                            || this.attributeType == 'multiselect'
                            || this.attributeType == 'boolean'
                            || this.attributeType == 'price';
                    },

                    isConfigurable() {
                        return this.attributeType == 'select';
                    },

                    canHaveDefaultValue() {
                        return this.attributeType == 'boolean';
                    },
                },

                created () {
                    this.getAttributesOption();
                },

                methods: {
                    storeOptions(params, { resetForm, setValues }) {
                        const lastId = this.optionsData.map(item => item.id).pop() ?? 0;

                        if (! params.id) {
                            params.id = `options_${lastId + 1}`;

                            this.optionId++;
                        }

                        let foundIndex = this.optionsData.findIndex(item => item.id === params.id);

                        if (foundIndex !== -1) {
                            params.isNew = String(params.id).startsWith('options_');

                            this.optionsData.splice(foundIndex, 1, params);
                        } else {
                            this.optionsData.push(params);
                        }

                        let formData = new FormData(this.$refs.editOptionsForm);

                        const sliderImage = formData.get("swatch_value[]");

                        if (sliderImage?.name) {
                            params.swatch_value = sliderImage;

                            if (sliderImage instanceof File) {
                                this.setFile(sliderImage, params.id);
                            }
                        }

                        this.$refs.addOptionsRow.toggle();

                        resetForm();
                    },

                    editOptions(value) {
                        this.optionIsNew = false;

                        this.swatchValue = {
                            image: value.swatch_value_url
                            ? [{ id: value.id, url: value.swatch_value_url }]
                            : [],
                        };

                        this.$refs.modelForm.setValues({
                            id: value.id,
                            admin_name: value.admin_name,
                            swatch_value: value.swatch_value,
                            swatch_value_url: value.swatch_value_url,
                            isNew: false,
                            locales: {
                                ...value.locales,
                            }
                        });

                        this.$refs.addOptionsRow.toggle();
                    },

                    removeOption(id) {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                let foundIndex = this.optionsData.findIndex(item => item.id === id);

                                if (foundIndex !== -1) {
                                    if (this.optionsData[foundIndex].isNew) {
                                        this.optionsData.splice(foundIndex, 1);
                                    } else {
                                        this.optionsData[foundIndex].isDelete = true;
                                    }
                                }

                                this.$emitter.emit('add-flash', { type: 'success', message: "@lang('dashboard::app.catalog.attributes.edit.option-deleted')" });
                            }
                        });
                    },

                    listenModel(event) {
                        if (! event.isActive) {
                            this.isNullOptionChecked = false;
                        }
                    },

                    getAttributesOption() {
                        this.$axios.get(`{{ route('admin.catalog.attributes.options', $attribute->id) }}`)
                            .then(response => {
                                let options = response.data;

                                options.forEach((option) => {
                                    let row = {
                                        'id': option.id,
                                        'admin_name': option.admin_name,
                                        'sort_order': option.sort_order,
                                        'swatch_value': option.swatch_value,
                                        'swatch_value_url': option.swatch_value_url,
                                        'swatch_alt': option.swatch_alt,
                                        'swatch_file_name': option.swatch_file_name,
                                        'notRequired': '',
                                        'locales': {},
                                        'isNew': false,
                                        'isDelete': false,
                                    };

                                    if (! option.label) {
                                        this.isNullOptionChecked = true;
                                        this.idNullOption = option.id;
                                        row['notRequired'] = true;
                                    } else {
                                        row['notRequired'] = false;
                                    }

                                    option.translations.forEach((translation) => {
                                        row['locales'][translation.locale] = translation.label ?? '';
                                    });

                                    this.optionsData.push(row);
                                });
                            });
                    },

                    setFile(file, id) {
                        let dataTransfer = new DataTransfer();

                        dataTransfer.items.add(file);

                        // Use Set timeout because need to wait for render dom before set the src or get the ref value
                        setTimeout(() => {
                            this.$refs['image_' + id].src =  URL.createObjectURL(file);

                            this.$refs['imageInput_' + id].files = dataTransfer.files;
                        }, 0);
                    }
                },
            });
        </script>
    @endPushOnce
</x-dashboard::layouts>
