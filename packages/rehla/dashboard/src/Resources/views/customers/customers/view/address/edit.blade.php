<v-edit-customer-address
    :address="address"
    @address-updated="addressUpdated"
></v-edit-customer-address>

@pushOnce('scripts')
    <!-- Customer Address Form -->
    <script
        type="text/x-template"
        id="v-edit-customer-address-template"
    >
        <div>
            <!-- Address Edit Button -->
            @if (bouncer()->hasPermission('customers.addresses.edit'))
                <p
                    class="cursor-pointer text-blue-600 transition-all hover:underline"
                    @click="$refs.customerAddressModal.toggle()"
                >
                    @lang('dashboard::app.customers.customers.view.address.edit.edit-btn')
                </p>
            @endif

            {!! view_render_event('rehla.dashboard.customers.addresses.edit.before') !!}

            <x-dashboard::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
            >
                {!! view_render_event('rehla.dashboard.customers.addresses.edit.edit_form_controls.before') !!}

                <form
                    @submit="handleSubmit($event, update)"
                    ref="createOrUpdateForm"
                >
                    <!-- Address Edit Drawer -->
                    <x-dashboard::drawer
                        width="350px"
                        ref="customerAddressModal"
                    >
                        <!-- Modal Header -->
                        <x-slot:header class="py-5">
                            <p class="text-lg font-bold text-gray-800 dark:text-white">
                                @lang('dashboard::app.customers.customers.view.address.edit.title')
                            </p>
                        </x-slot>

                        <!-- Drawer Content -->
                        <x-slot:content>

                            {!! view_render_event('rehla.dashboard.customer.addresses.edit.before') !!}

                            <!-- Company Name -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.customers.customers.view.address.edit.company-name')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="customer_id"
                                    ::value="address.customer_id"
                                />

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="address_id"
                                    ::value="address.id"
                                />

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="company_name"
                                    ::value="address.company_name"
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.company-name')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.edit.company-name')"
                                />

                                <x-dashboard::form.control-group.error control-name="company_name" />
                            </x-dashboard::form.control-group>

                            <!-- Vat Id -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.customers.customers.view.address.edit.vat-id')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="vat_id"
                                    ::value="address.vat_id"
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.vat-id')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.edit.vat-id')"
                                />

                                <x-dashboard::form.control-group.error control-name="vat_id" />
                            </x-dashboard::form.control-group>

                            <!-- First Name -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.address.edit.first-name')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="first_name"
                                    ::value="address.first_name"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.first-name')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.edit.first-name')"
                                />

                                <x-dashboard::form.control-group.error control-name="first_name" />
                            </x-dashboard::form.control-group>

                            <!-- Last Name -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.address.edit.last-name')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="last_name"
                                    ::value="address.last_name"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.last-name')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.edit.last-name')"
                                />

                                <x-dashboard::form.control-group.error control-name="last_name" />
                            </x-dashboard::form.control-group>

                            <!-- E-mail -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.address.edit.email')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="email"
                                    ::value="address.email"
                                    rules="required|email"
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.email')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.edit.email')"
                                />

                                <x-dashboard::form.control-group.error control-name="email" />
                            </x-dashboard::form.control-group>

                            <!--Phone number -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.address.edit.phone')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="phone"
                                    ::value="address.phone"
                                    rules="required|phone"
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.phone')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.edit.phone')"
                                />

                                <x-dashboard::form.control-group.error control-name="phone" />
                            </x-dashboard::form.control-group>

                            <!-- Street Address -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.address.edit.street-address')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    id="address[0]"
                                    name="address[0]"
                                    ::value="address.address.split('\n')[0]"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.street-address')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.edit.street-address')"
                                />

                                <x-dashboard::form.control-group.error
                                    class="mb-2"
                                    control-name="address[0]"
                                />
                            </x-dashboard::form.control-group>

                            <x-dashboard::form.control-group>
                                @if (core()->getConfigData('customer.address.information.street_lines') > 1)
                                    @for ($i = 1; $i < core()->getConfigData('customer.address.information.street_lines'); $i++)
                                        <x-dashboard::form.control-group.control
                                            type="text"
                                            id="address[{{ $i }}]"
                                            name="address[{{ $i }}]"
                                            ::value="address.address.split('\n')[{{ $i }}]"
                                            :label="trans('dashboard::app.customers.customers.view.address.edit.street-address')"
                                            :placeholder="trans('dashboard::app.customers.customers.view.address.edit.street-address')"
                                        />

                                        <x-dashboard::form.control-group.error control-name="address[{{ $i }}]" />
                                    @endfor
                                @endif
                            </x-dashboard::form.control-group>

                            <!-- City -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.address.edit.city')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="city"
                                    ::value="address.city"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.city')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.edit.city')"
                                />

                                <x-dashboard::form.control-group.error control-name="city" />
                            </x-dashboard::form.control-group>

                            <!-- PostCode -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.address.edit.post-code')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="postcode"
                                    ::value="address.postcode"
                                    rules="required|postcode"
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.post-code')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.address.edit.post-code')"
                                />

                                <x-dashboard::form.control-group.error control-name="postcode" />
                            </x-dashboard::form.control-group>

                            <!-- Country Name -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.customers.customers.view.address.edit.country')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="select"
                                    name="country"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.country')"
                                    v-model="address.country"
                                >
                                    @foreach (core()->countries() as $country)
                                        <option
                                            {{ $country->code === config('app.default_country') ? 'selected' : '' }}
                                            value="{{ $country->code }}"
                                        >
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </x-dashboard::form.control-group.control>

                                <x-dashboard::form.control-group.error control-name="country" />
                            </x-dashboard::form.control-group>

                            <!-- State Name -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.address.edit.state')
                                </x-dashboard::form.control-group.label>

                                <template v-if="haveStates()">
                                    <x-dashboard::form.control-group.control
                                        type="select"
                                        id="state"
                                        name="state"
                                        rules="required"
                                        :label="trans('dashboard::app.customers.customers.view.address.edit.state')"
                                        :placeholder="trans('dashboard::app.customers.customers.view.address.edit.state')"
                                        v-model="address.state"
                                    >
                                        <option
                                            v-for='(state, index) in countryStates[address.country]'
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
                                        ::value="address.state"
                                        rules="required"
                                        :label="trans('dashboard::app.customers.customers.view.address.edit.state')"
                                        :placeholder="trans('dashboard::app.customers.customers.view.address.edit.state')"
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
                                    :label="trans('dashboard::app.customers.customers.view.address.edit.default-address')"
                                    ::checked="address.default_address"
                                />

                                <label
                                    class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                    for="default_address"
                                >
                                    @lang('dashboard::app.customers.customers.view.address.edit.default-address')
                                </label>
                            </x-dashboard::form.control-group>

                            <x-dashboard::form.control-group.error control-name="default_address" />

                            {!! view_render_event('rehla.dashboard.customers.edit.after') !!}

                            <!-- Modal Submission -->
                            <x-dashboard::button
                                button-type="submit"
                                class="primary-button w-full max-w-full justify-center"
                                :title="trans('dashboard::app.customers.customers.view.address.edit.save-btn-title')"
                                ::loading="isLoading"
                                ::disabled="isLoading"
                            />
                        </x-slot>
                    </x-dashboard::drawer>
                </form>

                {!! view_render_event('rehla.dashboard.customers.addresses.edit.edit_form_controls.after') !!}

            </x-dashboard::form>

            {!! view_render_event('rehla.dashboard.customers.addresses.edit.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-edit-customer-address', {
            template: '#v-edit-customer-address-template',

            props: ['address'],

            emits: ['address-updated'],

            data() {
                return {
                    countryStates: @json(core()->groupedStatesByCountries()),

                    isLoading: false,
                };
            },

            methods: {
                update(params, { resetForm, setErrors }) {
                    this.isLoading = true;

                    let formData = new FormData(this.$refs.createOrUpdateForm);

                    formData.append('_method', 'put');

                    formData.append('default_address', formData.get('default_address') ? 1 : 0);

                    this.$axios.post('{{ route('admin.customers.customers.addresses.update', ':id') }}'.replace(':id', params?.address_id), formData)
                        .then((response) => {
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                            this.$emit('address-updated', response.data.data);

                            this.isLoading = false;

                            this.$refs.customerAddressModal.toggle();
                        })
                        .catch(error => {
                            this.isLoading = false;

                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);
                            }
                        });
                },

                haveStates() {
                    return !!this.countryStates[this.address.country]?.length;
                }
            }
        });
    </script>
@endPushOnce
