<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.settings.taxes.rates.create.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.settings.taxes.rates.create.before') !!}

    <x-dashboard::form :action="route('admin.settings.taxes.rates.store')">
        <div class="flex items-center justify-between">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.settings.taxes.rates.create.title')
            </p>

            <!-- Back Button -->
            <div class="flex items-center gap-x-2.5">
                <a
                    href="{{ route('admin.settings.taxes.rates.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('dashboard::app.settings.taxes.rates.create.back-btn')
                </a>

                <!-- Save Button -->
                <button 
                    type="submit" 
                    class="primary-button"
                >
                    @lang('dashboard::app.settings.taxes.rates.create.save-btn')
                </button>
            </div>
        </div>

        <v-create-taxrate>
            <!-- Shimmer Effect -->
            <x-dashboard::shimmer.settings.taxes.rates />
        </v-create-taxrate>
    </x-dashboard::form>

    {!! view_render_event('rehla.dashboard.settings.taxes.rates.create.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-create-taxrate-template"
        >

            {!! view_render_event('rehla.dashboard.settings.taxes.rates.create.create_form_controls.before') !!}

            <!-- Tax Rates information's -->
            <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
                <!-- Left Component -->
                <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                    <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                        <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                            @lang('dashboard::app.settings.taxes.rates.create.general')
                        </p>

                        <!-- Identifier -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.taxes.rates.create.identifier')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="identifier"
                                rules="required"
                                :value="old('identifier')"
                                :label="trans('dashboard::app.settings.taxes.rates.create.identifier')"
                                :placeholder="trans('dashboard::app.settings.taxes.rates.create.identifier')"
                            />

                            <x-dashboard::form.control-group.error control-name="identifier" />
                        </x-dashboard::form.control-group>

                        <!-- Country -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.taxes.rates.create.country')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="select"
                                name="country"
                                rules="required"
                                :value="old('country')"
                                v-model="country"
                                :label="trans('dashboard::app.settings.taxes.rates.create.country')"
                                :placeholder="trans('dashboard::app.settings.taxes.rates.create.country')"
                            >
                                <!-- Default Option -->
                                <option value="">
                                    @lang('dashboard::app.settings.taxes.rates.create.select-country')
                                </option>

                                @foreach (core()->countries() as $country)
                                    <option value="{{ $country->code }}">
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="country" />
                        </x-dashboard::form.control-group>

                        <!-- State -->
                        <x-dashboard::form.control-group>
                            <!-- Country Have States -->
                            <template v-if="haveStates()">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.taxes.rates.create.state')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="select"
                                    name="state"
                                    :value="old('state')"
                                    v-model="state"
                                    :label="trans('dashboard::app.settings.taxes.rates.create.state')"
                                    :placeholder="trans('dashboard::app.settings.taxes.rates.create.state')"
                                >
                                    <option value="">
                                        @lang('dashboard::app.settings.taxes.rates.edit.select-state')
                                    </option>

                                        <option
                                            v-for='(state, index) in countryStates[country]'
                                            :value="state.code"
                                        >
                                            @{{ state.default_name }}
                                        </option>
                                    </x-dashboard::form.control-group.control>

                                <x-dashboard::form.control-group.error control-name="state" />
                            </template>

                            <!-- Country Have not States -->
                            <template v-else>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.taxes.rates.create.state')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="state"
                                    :value="old('state')"
                                    :label="trans('dashboard::app.settings.taxes.rates.create.state')"
                                    :placeholder="trans('dashboard::app.settings.taxes.rates.create.state')"
                                />

                                <x-dashboard::form.control-group.error control-name="state" />
                            </template>
                        </x-dashboard::form.control-group>

                        <!-- Tax Rate -->
                        <x-dashboard::form.control-group class="!mb-0">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.taxes.rates.create.tax-rate')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="tax_rate"
                                {{-- rules="required|decimal|min:0|max:100" --}}
                                :value="old('tax_rate')"
                                :label="trans('dashboard::app.settings.taxes.rates.create.tax-rate')"
                                :placeholder="trans('dashboard::app.settings.taxes.rates.create.tax-rate')"
                            />

                            <x-dashboard::form.control-group.error control-name="tax_rate" />
                        </x-dashboard::form.control-group>
                    </div>
                </div>

                <!-- Right Component -->
                <div class="flex w-[360px] max-w-full flex-col gap-2 max-md:w-full">
                    <x-dashboard::accordion>
                        <x-slot:header>
                            <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('dashboard::app.settings.taxes.rates.create.settings')
                            </p>
                        </x-slot>

                        <x-slot:content>
                            <!-- Enable Zip Range -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.taxes.rates.create.is-zip')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="switch"
                                    name="is_zip"
                                    :value="1"
                                    v-model="is_zip"
                                    :label="trans('dashboard::app.settings.taxes.rates.create.is-zip')"
                                    :placeholder="trans('dashboard::app.settings.taxes.rates.create.is-zip')"
                                />

                                <x-dashboard::form.control-group.error control-name="is_zip" />
                            </x-dashboard::form.control-group>

                            <!-- Zip Code -->
                            <x-dashboard::form.control-group v-if="! is_zip" class="!mb-0">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.taxes.rates.create.zip-code')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="zip_code"
                                    :value="old('zip_code')"
                                    :label="trans('dashboard::app.settings.taxes.rates.create.zip-code')"
                                    :placeholder="trans('dashboard::app.settings.taxes.rates.create.zip-code')"
                                />

                                <x-dashboard::form.control-group.error control-name="zip_code" />
                            </x-dashboard::form.control-group>

                            <div v-if="is_zip">
                                <!-- Zip From -->
                                <x-dashboard::form.control-group>
                                    <x-dashboard::form.control-group.label class="required">
                                        @lang('dashboard::app.settings.taxes.rates.create.zip-from')
                                    </x-dashboard::form.control-group.label>

                                    <x-dashboard::form.control-group.control
                                        type="text"
                                        name="zip_from"
                                        rules="required"
                                        :value="old('zip_from')"
                                        :label="trans('dashboard::app.settings.taxes.rates.create.zip-from')"
                                        :placeholder="trans('dashboard::app.settings.taxes.rates.create.zip-from')"
                                    />

                                    <x-dashboard::form.control-group.error control-name="zip_from" />
                                </x-dashboard::form.control-group>

                                <!-- Zip To -->
                                <x-dashboard::form.control-group class="!mb-0">
                                    <x-dashboard::form.control-group.label class="required">
                                        @lang('dashboard::app.settings.taxes.rates.create.zip-to')
                                    </x-dashboard::form.control-group.label>

                                    <x-dashboard::form.control-group.control
                                        type="text"
                                        name="zip_to"
                                        rules="required"
                                        :value="old('zip_to')"
                                        :label="trans('dashboard::app.settings.taxes.rates.create.zip-to')"
                                        :placeholder="trans('dashboard::app.settings.taxes.rates.create.zip-to')"
                                    />

                                    <x-dashboard::form.control-group.error control-name="zip_to" />
                                </x-dashboard::form.control-group>
                            </div>
                        </x-slot>
                    </x-dashboard::accordion>
                </div>
            </div>

            {!! view_render_event('rehla.dashboard.settings.taxes.rates.create.create_form_controls.after') !!}

        </script>

        <script type="module">
            app.component('v-create-taxrate', {
                template: '#v-create-taxrate-template',

                data() {
                    return {
                        is_zip: false,

                        country: "{{ old('country')  }}",

                        state: "{{ old('state')  }}",

                        countryStates: @json(core()->groupedStatesByCountries())
                    }
                },

                methods: {
                    haveStates: function () {
                        /*
                        * The double negation operator is used to convert the value to a boolean.
                        * It ensures that the final result is a boolean value,
                        * true if the array has a length greater than 0, and otherwise false.
                        */
                        return !!this.countryStates[this.country]?.length;
                    },
                }
            });
        </script>
    @endPushOnce
</x-dashboard::layouts>
