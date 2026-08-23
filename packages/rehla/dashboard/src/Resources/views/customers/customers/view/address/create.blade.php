<v-create-customer-address @address-created="addressCreated">
    <div class="mr-1 inline-flex w-full max-w-max cursor-pointer items-center justify-between gap-x-2 px-1 py-1.5 text-center font-semibold text-gray-600 transition-all hover:rounded-md hover:bg-gray-200 dark:text-gray-300 dark:hover:bg-gray-800">
        <span class="icon-location text-2xl"></span>

        @lang('dashboard::app.customers.customers.view.address.create.create-address-btn')
    </div>
</v-create-customer-address>

<!-- Customer Address Modal -->
@pushOnce('scripts')
    <!-- Customer Address Form -->
    <script
        type="text/x-template"
        id="v-create-customer-address-template"
    >
        <!-- Address Create Button -->
        @if (bouncer()->hasPermission('customers.addresses.create'))
            <div
                class="flex cursor-pointer items-center justify-between gap-1.5 px-2.5 text-blue-600 transition-all hover:underline"
                @click="$refs.createAddress.toggle()"
            >
                @lang('dashboard::app.customers.customers.view.address.create.create-btn')
            </div>
        @endif

        {!! view_render_event('rehla.dashboard.customers.addresses.create.before') !!}

        <x-dashboard::form
            v-slot="{ meta, errors, handleSubmit }"
            as="div"
        >
            <form @submit="handleSubmit($event, create)">
                {!! view_render_event('rehla.dashboard.customers.addresses.create.create_form_controls.before') !!}

                <!-- Address Create Drawer -->
                <x-dashboard::drawer
                    width="350px"
                    ref="createAddress"
                >
                    <!-- Drawer Header -->
                    <x-slot:header class="py-5">
                        <p class="text-lg font-bold text-gray-800 dark:text-white">
                            @lang('dashboard::app.customers.customers.view.address.create.title')
                        </p>
                    </x-slot>

                    <!-- Drawer Content -->
                    <x-slot:content>
                        {!! view_render_event('rehla.dashboard.customers.addresses.create.before') !!}

                        <!-- Company Name -->
                        <x-dashboard::form.control-group class="w-full">
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.customers.customers.view.address.create.company-name')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="hidden"
                                name="customer_id"
                                :value="$customer->id"
                            />

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="company_name"
                                :label="trans('dashboard::app.customers.customers.view.address.create.company-name')"
                                :placeholder="trans('dashboard::app.customers.customers.view.address.create.company-name')"
                            />

                            <x-dashboard::form.control-group.error control-name="company_name" />
                        </x-dashboard::form.control-group>

                        <!-- Vat Id -->
                        <x-dashboard::form.control-group class="w-full">
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.customers.customers.view.address.create.vat-id')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="vat_id"
                                :label="trans('dashboard::app.customers.customers.view.address.create.vat-id')"
                                :placeholder="trans('dashboard::app.customers.customers.view.address.create.vat-id')"
                            />

                            <x-dashboard::form.control-group.error control-name="vat_id" />
                        </x-dashboard::form.control-group>

                        <!-- First Name -->
                        <x-dashboard::form.control-group class="w-full">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.view.address.create.first-name')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="first_name"
                                rules="required"
                                :label="trans('dashboard::app.customers.customers.view.address.create.first-name')"
                                :placeholder="trans('dashboard::app.customers.customers.view.address.create.first-name')"
                            />

                            <x-dashboard::form.control-group.error control-name="first_name" />
                        </x-dashboard::form.control-group>

                        <!-- Last Name -->
                        <x-dashboard::form.control-group class="w-full">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.view.address.create.last-name')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="last_name"
                                rules="required"
                                :label="trans('dashboard::app.customers.customers.view.address.create.last-name')"
                                :placeholder="trans('dashboard::app.customers.customers.view.address.create.last-name')"
                            />

                            <x-dashboard::form.control-group.error control-name="last_name" />
                        </x-dashboard::form.control-group>

                        <!-- E-mail -->
                        <x-dashboard::form.control-group class="w-full">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.view.address.create.email')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="email"
                                rules="required|email"
                                :label="trans('dashboard::app.customers.customers.view.address.create.email')"
                                :placeholder="trans('dashboard::app.customers.customers.view.address.create.email')"
                            />

                            <x-dashboard::form.control-group.error control-name="email" />
                        </x-dashboard::form.control-group>

                        <!--Phone number -->
                        <x-dashboard::form.control-group class="w-full">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.view.address.create.phone')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="phone"
                                rules="required|phone"
                                :label="trans('dashboard::app.customers.customers.view.address.create.phone')"
                                :placeholder="trans('dashboard::app.customers.customers.view.address.create.phone')"
                            />

                            <x-dashboard::form.control-group.error control-name="phone" />
                        </x-dashboard::form.control-group>

                        <!-- Street Address -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.view.address.create.street-address')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                id="address[0]"
                                name="address[0]"
                                class="mb-2"
                                rules="required"
                                :label="trans('dashboard::app.customers.customers.view.address.create.street-address')"
                                :placeholder="trans('dashboard::app.customers.customers.view.address.create.street-address')"
                            />

                            <x-dashboard::form.control-group.error
                                class="mb-2"
                                control-name="address[0]"
                            />

                            <x-dashboard::form.control-group.error control-name="address[]" />

                            @if (core()->getConfigData('customer.address.information.street_lines') > 1)
                                @for ($i = 1; $i < core()->getConfigData('customer.address.information.street_lines'); $i++)
                                    <x-dashboard::form.control-group.control
                                        type="text"
                                        id="address[{{ $i }}]"
                                        name="address[{{ $i }}]"
                                        :label="trans('dashboard::app.customers.customers.view.address.create.street-address')"
                                        :placeholder="trans('dashboard::app.customers.customers.view.address.create.street-address')"
                                    />

                                    <x-dashboard::form.control-group.error control-name="address[{{ $i }}]" />
                                @endfor
                            @endif
                        </x-dashboard::form.control-group>

                        <!-- City -->
                        <x-dashboard::form.control-group class="w-full">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.view.address.create.city')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="city"
                                rules="required"
                                :label="trans('dashboard::app.customers.customers.view.address.create.city')"
                                :placeholder="trans('dashboard::app.customers.customers.view.address.create.city')"
                            />

                            <x-dashboard::form.control-group.error control-name="city" />
                        </x-dashboard::form.control-group>

                        <!-- PostCode -->
                        <x-dashboard::form.control-group class="w-full">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.view.address.create.post-code')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="postcode"
                                rules="required|postcode"
                                :label="trans('dashboard::app.customers.customers.view.address.create.post-code')"
                                :placeholder="trans('dashboard::app.customers.customers.view.address.create.post-code')"
                            />

                            <x-dashboard::form.control-group.error control-name="postcode" />
                        </x-dashboard::form.control-group>

                        <!-- Country Name -->
                        <x-dashboard::form.control-group class="w-full">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.view.address.create.country')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="select"
                                name="country"
                                rules="required"
                                v-model="country"
                                :label="trans('dashboard::app.customers.customers.view.address.create.country')"
                            >
                                @foreach (core()->countries() as $country)
                                    <option value="{{ $country->code }}">{{ $country->name }}</option>
                                @endforeach
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="country" />
                        </x-dashboard::form.control-group>

                        <!-- State Name -->
                        <x-dashboard::form.control-group class="w-full">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.view.address.create.state')
                            </x-dashboard::form.control-group.label>

                            <template v-if="haveStates()">
                                <x-dashboard::form.control-group.control
                                    type="select"
                                    id="state"
                                    name="state"
                                    rules="required"
                                    v-model="state"
                                    :label="trans('dashboard::app.customers.customers.view.address.create.state')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.create.state')"
                                >
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
                                    name="state"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.view.address.create.state')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.create.state')"
                                />
                            </template>

                            <x-dashboard::form.control-group.error control-name="state" />
                        </x-dashboard::form.control-group>

                        <!-- Default Address -->
                        <x-dashboard::form.control-group class="flex items-center gap-2.5">
                            <x-dashboard::form.control-group.control
                                type="checkbox"
                                id="default_address"
                                name="default_address"
                                :value="1"
                                for="default_address"
                                :label="trans('dashboard::app.customers.customers.view.address.create.default-address')"
                                :checked="false"
                            />

                            <label
                                class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                for="default_address"
                            >
                                @lang('dashboard::app.customers.customers.view.address.create.default-address')
                            </label>
                        </x-dashboard::form.control-group>

                        <x-dashboard::form.control-group.error control-name="default_address" />

                        {!! view_render_event('rehla.dashboard.customers.create.after') !!}

                        <!-- Modal Submission -->
                        <x-dashboard::button
                            button-type="submit"
                            class="primary-button w-full max-w-full justify-center"
                            :title="trans('dashboard::app.customers.customers.view.address.create.save-btn-title')"
                            ::loading="isLoading"
                            ::disabled="isLoading"
                        />
                    </x-slot>
                </x-dashboard::drawer>

                {!! view_render_event('rehla.dashboard.customers.addresses.create.create_form_controls.after') !!}

            </form>
        </x-dashboard::form>

        {!! view_render_event('rehla.dashboard.customers.addresses.create.after') !!}

    </script>

    <script type="module">
        app.component('v-create-customer-address', {
            template: '#v-create-customer-address-template',

            emits: ['address-created'],

            data() {
                return {
                    country: "",

                    state: "",

                    countryStates: @json(core()->groupedStatesByCountries()),

                    isLoading: false,
                };
            },

            methods: {
                create(params, { resetForm, setErrors }) {
                    this.isLoading = true;

                    params.default_address = params.default_address ?? 0;

                    this.$axios.post('{{ route('admin.customers.customers.addresses.store', $customer->id) }}', params)
                        .then((response) => {
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                            this.$emit('address-created', response.data.data);

                            resetForm();

                            this.isLoading = false;

                            this.$refs.createAddress.toggle();
                        })
                        .catch(error => {
                            this.isLoading = false;

                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);
                            }
                        });
                },

                haveStates() {
                    /*
                    * The double negation operator is used to convert the value to a boolean.
                    * It ensures that the final result is a boolean value,
                    * true if the array has a length greater than 0, and otherwise false.
                    */
                    return !!this.countryStates[this.country]?.length;
                },
            },
        });
    </script>
@endPushOnce
