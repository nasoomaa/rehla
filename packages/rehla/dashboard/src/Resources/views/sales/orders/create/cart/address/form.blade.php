@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-form-template"
    >
        <div class="mt-2">
            <x-dashboard::form.control-group class="hidden">
                <x-dashboard::form.control-group.control
                    type="text"
                    ::name="controlName + '.id'"
                    ::value="address.id"
                />
            </x-dashboard::form.control-group>

            <!-- Company Name -->
            <x-dashboard::form.control-group>
                <x-dashboard::form.control-group.label>
                    @lang('dashboard::app.sales.orders.create.cart.address.company-name')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="text"
                    ::name="controlName + '.company_name'"
                    ::value="address.company_name"
                    :placeholder="trans('dashboard::app.sales.orders.create.cart.address.company-name')"
                />
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.company_name.after') !!}

            <!-- VatId Name -->
            <x-dashboard::form.control-group>
                <x-dashboard::form.control-group.label>
                    @lang('dashboard::app.sales.orders.create.cart.address.vat-id')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="text"
                    ::name="controlName + '.vat_id'"
                    ::value="address.vat_id"
                    :label="trans('dashboard::app.sales.orders.create.cart.address.vat-id')"
                    :placeholder="trans('dashboard::app.sales.orders.create.cart.address.vat-id')"
                />

                <x-dashboard::form.control-group.error ::name="controlName + '.vat_id'" />
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.vat_id.after') !!}

            <!-- First Name -->
            <x-dashboard::form.control-group>
                <x-dashboard::form.control-group.label class="required !mt-0">
                    @lang('dashboard::app.sales.orders.create.cart.address.first-name')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="text"
                    ::name="controlName + '.first_name'"
                    ::value="address.first_name"
                    rules="required"
                    :label="trans('dashboard::app.sales.orders.create.cart.address.first-name')"
                    :placeholder="trans('dashboard::app.sales.orders.create.cart.address.first-name')"
                />

                <x-dashboard::form.control-group.error ::name="controlName + '.first_name'" />
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.first_name.after') !!}

            <!-- Last Name -->
            <x-dashboard::form.control-group>
                <x-dashboard::form.control-group.label class="required !mt-0">
                    @lang('dashboard::app.sales.orders.create.cart.address.last-name')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="text"
                    ::name="controlName + '.last_name'"
                    ::value="address.last_name"
                    rules="required"
                    :label="trans('dashboard::app.sales.orders.create.cart.address.last-name')"
                    :placeholder="trans('dashboard::app.sales.orders.create.cart.address.last-name')"
                />

                <x-dashboard::form.control-group.error ::name="controlName + '.last_name'" />
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.last_name.after') !!}

            <!-- Email -->
            <x-dashboard::form.control-group>
                <x-dashboard::form.control-group.label class="required !mt-0">
                    @lang('dashboard::app.sales.orders.create.cart.address.email')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="email"
                    ::name="controlName + '.email'"
                    ::value="address.email"
                    rules="required|email"
                    :label="trans('dashboard::app.sales.orders.create.cart.address.email')"
                    placeholder="email@example.com"
                />

                <x-dashboard::form.control-group.error ::name="controlName + '.email'" />
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.email.after') !!}

            <!-- Street Address -->
            <x-dashboard::form.control-group>
                <x-dashboard::form.control-group.label class="required !mt-0">
                    @lang('dashboard::app.sales.orders.create.cart.address.street-address')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="text"
                    ::name="controlName + '.address.[0]'"
                    ::value="address.address[0]"
                    rules="required|address"
                    :label="trans('dashboard::app.sales.orders.create.cart.address.street-address')"
                    :placeholder="trans('dashboard::app.sales.orders.create.cart.address.street-address')"
                />

                <x-dashboard::form.control-group.error
                    class="mb-2"
                    ::name="controlName + '.address.[0]'"
                />

                @if (core()->getConfigData('customer.address.information.street_lines') > 1)
                    @for ($i = 1; $i < core()->getConfigData('customer.address.information.street_lines'); $i++)
                        <x-dashboard::form.control-group.control
                            type="text"
                            ::name="controlName + '.address.[{{ $i }}]'"
                            class="mt-2"
                            rules="address"
                            :label="trans('dashboard::app.sales.orders.create.cart.address.street-address')"
                            :placeholder="trans('dashboard::app.sales.orders.create.cart.address.street-address')"
                        />

                        <x-dashboard::form.control-group.error
                            class="mb-2"
                            ::name="controlName + '.address.[{{ $i }}]'"
                        />
                    @endfor
                @endif
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.address.after') !!}

            <!-- Country -->
            <x-dashboard::form.control-group class="!mb-4">
                <x-dashboard::form.control-group.label class="{{ core()->isCountryRequired() ? 'required' : '' }} !mt-0">
                    @lang('dashboard::app.sales.orders.create.cart.address.country')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="select"
                    ::name="controlName + '.country'"
                    ::value="address.country"
                    v-model="selectedCountry"
                    rules="{{ core()->isCountryRequired() ? 'required' : '' }}"
                    :label="trans('dashboard::app.sales.orders.create.cart.address.country')"
                    :placeholder="trans('dashboard::app.sales.orders.create.cart.address.country')"
                >
                    <option value="">
                        @lang('dashboard::app.sales.orders.create.cart.address.select-country')
                    </option>

                    <option
                        v-for="country in countries"
                        :value="country.code"
                    >
                        @{{ country.name }}
                    </option>
                </x-dashboard::form.control-group.control>

                <x-dashboard::form.control-group.error ::name="controlName + '.country'" />
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.country.after') !!}

            <!-- State -->
            <x-dashboard::form.control-group>
                <x-dashboard::form.control-group.label class="{{ core()->isStateRequired() ? 'required' : '' }} !mt-0">
                    @lang('dashboard::app.sales.orders.create.cart.address.state')
                </x-dashboard::form.control-group.label>

                <template v-if="states">
                    <template v-if="haveStates">
                        <x-dashboard::form.control-group.control
                            type="select"
                            ::name="controlName + '.state'"
                            ::value="address.state"
                            rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                            :label="trans('dashboard::app.sales.orders.create.cart.address.state')"
                            :placeholder="trans('dashboard::app.sales.orders.create.cart.address.state')"
                        >
                            <option value="">
                                @lang('dashboard::app.sales.orders.create.cart.address.select-state')
                            </option>

                            <option
                                v-for='state in states[selectedCountry]'
                                :value="state.code"
                            >
                                @{{ state.default_name }}
                            </option>
                        </x-dashboard::form.control-group.control>
                    </template>

                    <template v-else>
                        <x-dashboard::form.control-group.control
                            type="text"
                            ::name="controlName + '.state'"
                            ::value="address.state"
                            rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                            :label="trans('dashboard::app.sales.orders.create.cart.address.state')"
                            :placeholder="trans('dashboard::app.sales.orders.create.cart.address.state')"
                        />
                    </template>
                </template>

                <x-dashboard::form.control-group.error ::name="controlName + '.state'" />
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.state.after') !!}

            <!-- City -->
            <x-dashboard::form.control-group>
                <x-dashboard::form.control-group.label class="required !mt-0">
                    @lang('dashboard::app.sales.orders.create.cart.address.city')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="text"
                    ::name="controlName + '.city'"
                    ::value="address.city"
                    rules="required"
                    :label="trans('dashboard::app.sales.orders.create.cart.address.city')"
                    :placeholder="trans('dashboard::app.sales.orders.create.cart.address.city')"
                />

                <x-dashboard::form.control-group.error ::name="controlName + '.city'" />
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.city.after') !!}

            <!-- Postcode -->
            <x-dashboard::form.control-group>
                <x-dashboard::form.control-group.label class="{{ core()->isPostCodeRequired() ? 'required' : '' }} !mt-0">
                    @lang('dashboard::app.sales.orders.create.cart.address.postcode')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="text"
                    ::name="controlName + '.postcode'"
                    ::value="address.postcode"
                    rules="{{ core()->isPostCodeRequired() ? 'required' : '' }}|postcode"
                    :label="trans('dashboard::app.sales.orders.create.cart.address.postcode')"
                    :placeholder="trans('dashboard::app.sales.orders.create.cart.address.postcode')"
                />

                <x-dashboard::form.control-group.error ::name="controlName + '.postcode'" />
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.postcode.after') !!}

            <!-- Phone Number -->
            <x-dashboard::form.control-group>
                <x-dashboard::form.control-group.label class="required !mt-0">
                    @lang('dashboard::app.sales.orders.create.cart.address.telephone')
                </x-dashboard::form.control-group.label>

                <x-dashboard::form.control-group.control
                    type="text"
                    ::name="controlName + '.phone'"
                    ::value="address.phone"
                    rules="required|numeric"
                    :label="trans('dashboard::app.sales.orders.create.cart.address.telephone')"
                    :placeholder="trans('dashboard::app.sales.orders.create.cart.address.telephone')"
                />

                <x-dashboard::form.control-group.error ::name="controlName + '.phone'" />
            </x-dashboard::form.control-group>

            {!! view_render_event('rehla.dashboard.sales.order.create.cart.address.form.phone.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-checkout-address-form', {
            template: '#v-checkout-address-form-template',

            props: {
                controlName: {
                    type: String,
                    required: true,
                },

                address: {
                    type: Object,

                    default: () => ({
                        id: 0,
                        company_name: '',
                        first_name: '',
                        last_name: '',
                        email: '',
                        address: [],
                        country: '',
                        state: '',
                        city: '',
                        postcode: '',
                        phone: '',
                    }),
                },
            },

            data() {
                return {
                    selectedCountry: this.address.country,

                    countries: [],

                    states: null,
                }
            },

            created() {
                this.getCountries();

                this.getStates();
            },

            computed: {
                haveStates() {
                    return !! this.states[this.selectedCountry]?.length;
                },
            },

            methods: {
                getCountries() {
                    this.$axios.get("{{ route('shop.api.core.countries') }}")
                        .then(response => {
                            this.countries = response.data.data;
                        })
                        .catch(() => {});
                },

                getStates() {
                    this.$axios.get("{{ route('shop.api.core.states') }}")
                        .then(response => {
                            this.states = response.data.data;
                        })
                        .catch(() => {});
                },
            }
        });
    </script>
@endPushOnce