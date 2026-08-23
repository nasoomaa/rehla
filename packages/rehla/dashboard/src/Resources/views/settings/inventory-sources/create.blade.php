<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.settings.inventory-sources.create.add-title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.before') !!}

    <x-dashboard::form 
        :action="route('admin.settings.inventory_sources.store')"
        enctype="multipart/form-data"
    >

        {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.create_form_controls.before') !!}

        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.settings.inventory-sources.create.add-title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.settings.inventory_sources.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('dashboard::app.marketing.communications.campaigns.create.back-btn')
                </a>
                    
                <!-- Save Inventory -->
                <button 
                    type="submit"
                    class="primary-button"
                >
                    @lang('dashboard::app.settings.inventory-sources.create.save-btn')
                </button>
            </div>
        </div>
    
        <!-- Full Panel -->
        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <!-- Left Section -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">

                {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.card.general.before') !!}

                <!-- General -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('dashboard::app.settings.inventory-sources.create.general')
                    </p>

                    <!-- Code -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.inventory-sources.create.code')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="code"
                            name="code"
                            rules="required"
                            :value="old('code')"
                            :label="trans('dashboard::app.settings.inventory-sources.create.code')"
                            :placeholder="trans('dashboard::app.settings.inventory-sources.create.code')"
                        />

                        <x-dashboard::form.control-group.error control-name="code" />
                    </x-dashboard::form.control-group>

                    <!-- Name -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.inventory-sources.create.name')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="name"
                            name="name"
                            rules="required"
                            :value="old('name')"
                            :label="trans('dashboard::app.settings.inventory-sources.create.name')"
                            :placeholder="trans('dashboard::app.settings.inventory-sources.create.name')"
                        />

                        <x-dashboard::form.control-group.error control-name="name" />
                    </x-dashboard::form.control-group>

                    <!-- Description -->
                    <x-dashboard::form.control-group class="!mb-0">
                        <x-dashboard::form.control-group.label>
                            @lang('dashboard::app.settings.inventory-sources.create.description')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="textarea"
                            class="!mb-0 text-gray-600 dark:text-gray-300"
                            id="description"
                            name="description"
                            :value="old('description')"
                            :label="trans('dashboard::app.settings.inventory-sources.create.description')"
                            :placeholder="trans('dashboard::app.settings.inventory-sources.create.description')"
                        />

                        <x-dashboard::form.control-group.error control-name="description" />
                    </x-dashboard::form.control-group>
                </div>

                {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.card.general.after') !!}

                {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.card.contact_info.before') !!}

                <!-- Contact Information -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('dashboard::app.settings.inventory-sources.create.contact-info')
                    </p>

                    <!-- Contact name -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.inventory-sources.create.contact-name')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="contact_name"
                            name="contact_name"
                            rules="required"
                            :value="old('contact_name')"
                            :label="trans('dashboard::app.settings.inventory-sources.create.contact-name')"
                            :placeholder="trans('dashboard::app.settings.inventory-sources.create.contact-name')"
                        />

                        <x-dashboard::form.control-group.error control-name="contact_name" />
                    </x-dashboard::form.control-group>

                    <!-- Contact Email -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.inventory-sources.create.contact-email')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="email"
                            id="contact_email"
                            name="contact_email"
                            rules="required|email"
                            :value="old('contact_email')"
                            :label="trans('dashboard::app.settings.inventory-sources.create.contact-email')"
                            :placeholder="trans('dashboard::app.settings.inventory-sources.create.contact-email')"
                        />

                        <x-dashboard::form.control-group.error control-name="contact_email" />
                    </x-dashboard::form.control-group>

                    <!-- Contact Number -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.inventory-sources.create.contact-number')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="contact_number"
                            name="contact_number"
                            rules="required"
                            :value="old('contact_number')"
                            :label="trans('dashboard::app.settings.inventory-sources.create.contact-number')"
                            :placeholder="trans('dashboard::app.settings.inventory-sources.create.contact-number')"
                        />

                        <x-dashboard::form.control-group.error control-name="contact_number" />
                    </x-dashboard::form.control-group>

                    <!-- Contact fax -->
                    <x-dashboard::form.control-group class="!mb-0">
                        <x-dashboard::form.control-group.label>
                            @lang('dashboard::app.settings.inventory-sources.create.contact-fax')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="text"
                            id="contact_fax"
                            name="contact_fax"
                            :value="old('contact_fax')"
                            :label="trans('dashboard::app.settings.inventory-sources.create.contact-fax')"
                            :placeholder="trans('dashboard::app.settings.inventory-sources.create.contact-fax')"
                        />

                        <x-dashboard::form.control-group.error control-name="contact_fax" />
                    </x-dashboard::form.control-group>
                </div>

                {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.card.contact_info.after') !!}

                {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.card.address.before') !!}

                <!-- Source Address -->
                <v-source-address></v-source-address>

                {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.card.address.after') !!}

            </div>

            <!-- Right Section -->
            <div class="flex w-[360px] max-w-full flex-col gap-2">

                {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.card.accordion.settings.before') !!}

                <!-- Settings -->
                <x-dashboard::accordion>
                    <x-slot:header>
                        <div class="flex items-center justify-between">
                            <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('dashboard::app.settings.inventory-sources.create.settings')
                            </p>
                        </div>
                    </x-slot>
                
                    <x-slot:content>
                        <!-- Latitude -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.settings.inventory-sources.create.latitude')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                id="latitude"
                                name="latitude"
                                :value="old('latitude')"
                                :label="trans('dashboard::app.settings.inventory-sources.create.latitude')"
                                :placeholder="trans('dashboard::app.settings.inventory-sources.create.latitude')"
                            />

                            <x-dashboard::form.control-group.error control-name="latitude" />
                        </x-dashboard::form.control-group>

                        <!-- Longitude -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.settings.inventory-sources.create.longitude')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                id="longitude"
                                name="longitude"
                                :value="old('longitude')"
                                :label="trans('dashboard::app.settings.inventory-sources.create.longitude')"
                                :placeholder="trans('dashboard::app.settings.inventory-sources.create.longitude')"
                            />

                            <x-dashboard::form.control-group.error control-name="longitude" />
                        </x-dashboard::form.control-group>

                        <!-- Priority -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.settings.inventory-sources.create.priority')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                id="priority"
                                name="priority"
                                :value="old('priority')"
                                :label="trans('dashboard::app.settings.inventory-sources.create.priority')"
                                :placeholder="trans('dashboard::app.settings.inventory-sources.create.priority')"
                            />

                            <x-dashboard::form.control-group.error control-name="priority" />
                        </x-dashboard::form.control-group>

                        <!-- Status -->
                        <x-dashboard::form.control-group class="!mb-0">
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.settings.inventory-sources.create.status')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="hidden"
                                name="status"
                                value="0"
                            />

                            <x-dashboard::form.control-group.control
                                type="switch"
                                name="status"
                                value="1"
                                :label="trans('dashboard::app.settings.inventory-sources.create.status')"
                                :placeholder="trans('dashboard::app.settings.inventory-sources.create.status')"
                                :checked="(bool) old('status')"
                            />

                            <x-dashboard::form.control-group.error control-name="status" />
                        </x-dashboard::form.control-group>
                    </x-slot>
                </x-dashboard::accordion>

                {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.card.accordion.settings.after') !!}

            </div>
        </div>

        {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.create_form_controls.after') !!}

    </x-dashboard::form>

    {!! view_render_event('rehla.dashboard.settings.inventory_sources.create.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-source-address-template"
        >
            <!-- Source Address -->
            <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                    @lang('dashboard::app.settings.inventory-sources.create.address')
                </p>

                <!-- Country -->
                <x-dashboard::form.control-group>
                    <x-dashboard::form.control-group.label class="required">
                        @lang('dashboard::app.settings.inventory-sources.create.country')
                    </x-dashboard::form.control-group.label>
    
                    <x-dashboard::form.control-group.control
                        type="select"
                        id="country"
                        name="country"
                        rules="required"
                        v-model="country"
                        :label="trans('dashboard::app.settings.inventory-sources.create.country')"
                        :placeholder="trans('dashboard::app.settings.inventory-sources.create.country')"
                    >
                        <option value="">
                            @lang('dashboard::app.settings.inventory-sources.create.select-country')
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
                    <x-dashboard::form.control-group.label class="required">
                        @lang('dashboard::app.settings.inventory-sources.create.state')
                    </x-dashboard::form.control-group.label>
    
                    <template v-if="haveStates()">
                        <x-dashboard::form.control-group.control
                            type="select"
                            id="state"
                            name="state"
                            rules="required"
                            :value="old('state')"
                            :label="trans('dashboard::app.settings.inventory-sources.create.state')"
                            :placeholder="trans('dashboard::app.settings.inventory-sources.create.state')"
                        >
                            <option value="">
                                @lang('dashboard::app.settings.inventory-sources.create.select-state')
                            </option>

                            <option 
                                v-for='(state, index) in countryStates[country]'
                                :value="state.code"
                            >
                                @{{ state.default_name }}
                            </option>
                        </x-dashboard::form.control-group.control>
                    </template>
    
                    <template v-else>
                        <x-dashboard::form.control-group.control
                            type="text"
                            id="state"
                            name="state"
                            rules="required"
                            :value="old('state')"
                            v-model="state"
                            :label="trans('dashboard::app.settings.inventory-sources.create.state')"
                            :placeholder="trans('dashboard::app.settings.inventory-sources.create.state')"
                        />
                    </template>

                    <x-dashboard::form.control-group.error control-name="state" />
                </x-dashboard::form.control-group>

                <!-- City -->
                <x-dashboard::form.control-group>
                    <x-dashboard::form.control-group.label class="required">
                        @lang('dashboard::app.settings.inventory-sources.create.city')
                    </x-dashboard::form.control-group.label>

                    <x-dashboard::form.control-group.control
                        type="text"
                        id="city"
                        name="city"
                        rules="required"
                        :value="old('city')"
                        :label="trans('dashboard::app.settings.inventory-sources.create.city')"
                        :placeholder="trans('dashboard::app.settings.inventory-sources.create.city')"
                    />

                    <x-dashboard::form.control-group.error control-name="city" />
                </x-dashboard::form.control-group>

                <!-- Street -->
                <x-dashboard::form.control-group>
                    <x-dashboard::form.control-group.label class="required">
                        @lang('dashboard::app.settings.inventory-sources.create.street')
                    </x-dashboard::form.control-group.label>

                    <x-dashboard::form.control-group.control
                        type="text"
                        id="street"
                        name="street"
                        rules="required"
                        :value="old('street')"
                        :label="trans('dashboard::app.settings.inventory-sources.create.street')"
                        :placeholder="trans('dashboard::app.settings.inventory-sources.create.street')"
                    />

                    <x-dashboard::form.control-group.error control-name="street" />
                </x-dashboard::form.control-group>

                <!-- postcode -->
                <x-dashboard::form.control-group class="!mb-0">
                    <x-dashboard::form.control-group.label class="required">
                        @lang('dashboard::app.settings.inventory-sources.create.postcode')
                    </x-dashboard::form.control-group.label>

                    <x-dashboard::form.control-group.control
                        type="text"
                        id="postcode"
                        name="postcode"
                        rules="required|postcode"
                        :value="old('postcode')"
                        :label="trans('dashboard::app.settings.inventory-sources.create.postcode')"
                        :placeholder="trans('dashboard::app.settings.inventory-sources.create.postcode')"
                    />

                    <x-dashboard::form.control-group.error control-name="postcode" />
                </x-dashboard::form.control-group>
            </div>
        </script>

        <script type="module">
            app.component('v-source-address', {
                template: '#v-source-address-template',

                data() {
                    return {
                        country: "{{ old('country') }}",

                        state: "{{ old('state')  }}",

                        countryStates: @json(core()->groupedStatesByCountries())
                    }
                },

                methods: {
                    haveStates() {
                        /*
                        * The double negation operator is used to convert the value to a boolean.
                        * It ensures that the final result is a boolean value,
                        * true if the array has a length greater than 0, and otherwise false.
                        */
                        return !!this.countryStates[this.country]?.length;
                    },
                }
            })
        </script>
    @endpushOnce
</x-dashboard::layouts>
