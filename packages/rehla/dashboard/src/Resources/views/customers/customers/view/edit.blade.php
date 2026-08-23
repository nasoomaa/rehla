<v-customer-edit
    :customer="customer"
    @update-customer="updateCustomer"
>
    <div class="flex cursor-pointer items-center justify-between gap-1.5 px-2.5 text-blue-600 transition-all hover:underline"></div>
</v-customer-edit>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-customer-edit-template"
    >
        <!-- Customer Edit Button -->
        @if (bouncer()->hasPermission('customers.customers.edit'))
            <div 
                class="flex cursor-pointer items-center justify-between gap-1.5 px-2.5 text-blue-600 transition-all hover:underline"
                @click="$refs.customerEditModal.toggle()"
            >
                @lang('dashboard::app.customers.customers.view.edit.edit-btn')
            </div>
        @endif

        {!! view_render_event('rehla.dashboard.customers.customers.view.edit.edit_form_controls.before', ['customer' => $customer]) !!}

        <x-dashboard::form
            v-slot="{ meta, errors, handleSubmit }"
            as="div"
        >
            <form
                @submit="handleSubmit($event, edit)"
                ref="customerEditForm"
            >
                <!-- Customer Edit Modal -->
                <x-dashboard::modal ref="customerEditModal">
                    <!-- Modal Header -->
                    <x-slot:header>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">
                            @lang('dashboard::app.customers.customers.view.edit.title')
                        </p>    
                    </x-slot>
    
                    <!-- Modal Content -->
                    <x-slot:content>
                        {!! view_render_event('rehla.dashboard.customers.customers.view.edit.before', ['customer' => $customer]) !!}

                        <div class="flex gap-4 max-sm:flex-wrap">
                            <!--First Name -->
                            <x-dashboard::form.control-group class="mb-2.5 w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.edit.first-name')
                                </x-dashboard::form.control-group.label>
            
                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="first_name" 
                                    id="first_name" 
                                    ::value="customer.first_name"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.view.edit.first-name')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.edit.first-name')"
                                />
            
                                <x-dashboard::form.control-group.error control-name="first_name" />
                            </x-dashboard::form.control-group>
            
                            <!--Last Name -->
                            <x-dashboard::form.control-group class="mb-2.5 w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.edit.last-name')
                                </x-dashboard::form.control-group.label>
            
                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="last_name" 
                                    ::value="customer.last_name"
                                    id="last_name"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.view.edit.last-name')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.edit.last-name')"
                                />
            
                                <x-dashboard::form.control-group.error control-name="last_name" />
                            </x-dashboard::form.control-group>
                        </div>
            
                        <!-- Email -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.view.edit.email')
                            </x-dashboard::form.control-group.label>
            
                            <x-dashboard::form.control-group.control
                                type="email"
                                name="email"
                                ::value="customer.email"
                                id="email"
                                rules="required|email"
                                :label="trans('dashboard::app.customers.customers.view.edit.email')"
                                placeholder="email@example.com"
                            />
            
                            <x-dashboard::form.control-group.error control-name="email" />
                        </x-dashboard::form.control-group>
            
                        <div class="flex gap-4 max-sm:flex-wrap">
                            <!-- Phone -->
                            <x-dashboard::form.control-group class="mb-2.5 w-full">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.customers.customers.view.edit.contact-number')
                                </x-dashboard::form.control-group.label>
            
                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="phone"
                                    ::value="customer.phone"
                                    id="phone"
                                    rules="phone"
                                    :label="trans('dashboard::app.customers.customers.view.edit.contact-number')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.edit.contact-number')"
                                />
            
                                <x-dashboard::form.control-group.error control-name="phone" />
                            </x-dashboard::form.control-group>
            
                            <!-- Date -->
                            <x-dashboard::form.control-group class="mb-2.5 w-full">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.customers.customers.view.edit.date-of-birth')
                                </x-dashboard::form.control-group.label>
            
                                <x-dashboard::form.control-group.control
                                    type="date"
                                    name="date_of_birth" 
                                    id="dob"
                                    ::value="customer.date_of_birth"
                                    :label="trans('dashboard::app.customers.customers.view.edit.date-of-birth')"
                                    :placeholder="trans('dashboard::app.customers.customers.view.edit.date-of-birth')"
                                />
                                
                                <x-dashboard::form.control-group.error control-name="date_of_birth" />
                            </x-dashboard::form.control-group>
                        </div>

                        <div class="flex gap-4 max-sm:flex-wrap">
                            <!-- Gender -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.view.edit.gender')
                                </x-dashboard::form.control-group.label>
            
                                <x-dashboard::form.control-group.control
                                    type="select"
                                    name="gender"
                                    ::value="customer.gender"
                                    id="gender"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.view.edit.gender')"
                                >
                                    <option value="Male">
                                        @lang('dashboard::app.customers.customers.view.edit.male')
                                    </option>
            
                                    <option value="Female">
                                        @lang('dashboard::app.customers.customers.view.edit.female')
                                    </option>
            
                                    <option value="Other">
                                        @lang('dashboard::app.customers.customers.view.edit.other')
                                    </option>
                                </x-dashboard::form.control-group.control>
            
                                <x-dashboard::form.control-group.error control-name="gender" />
                            </x-dashboard::form.control-group>
            
                            <!-- Customer Group -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.customers.customers.view.edit.customer-group')
                                </x-dashboard::form.control-group.label>
            
                                <x-dashboard::form.control-group.control
                                    type="select"
                                    name="customer_group_id"
                                    ::value="customer.customer_group_id"
                                    id="customerGroup" 
                                    :label="trans('dashboard::app.customers.customers.view.edit.customer-group')"
                                >
                                    <option
                                        v-for="group in groups" 
                                        :value="group.id"
                                    > 
                                        @{{ group.name }} 
                                    </option>
                                </x-dashboard::form.control-group.control>
                            </x-dashboard::form.control-group>
                        </div>
            
                        <div class="flex gap-60 max-sm:flex-wrap">
                            <!-- Customer Status -->
                            <x-dashboard::form.control-group class="!mb-0">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.marketing.promotions.cart-rules.edit.status')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="status"
                                    value="0"
                                />
                                
                                <x-dashboard::form.control-group.control
                                    type="switch"
                                    name="status"
                                    :value="1"
                                    :label="trans('dashboard::app.marketing.promotions.cart-rules.edit.status')"
                                    ::checked="customer.status"
                                />
                            </x-dashboard::form.control-group>

                            <!-- Customer Suspended Status -->
                            <x-dashboard::form.control-group class="!mb-0">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.customers.customers.view.edit.suspended')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="hidden"
                                    name="is_suspended"
                                    value="0"
                                />
                                
                                <x-dashboard::form.control-group.control
                                    type="switch"
                                    name="is_suspended"
                                    :value="1"
                                    :label="trans('dashboard::app.customers.customers.view.edit.suspended')"
                                    ::checked="customer.is_suspended"
                                />
                            </x-dashboard::form.control-group>
                        </div>
                        
                        {!! view_render_event('rehla.dashboard.customers.customers.view.edit.after', ['customer' => $customer]) !!}
                    </x-slot>

                    <!-- Modal Footer -->
                    <x-slot:footer>
                        <!-- Save Button -->
                        <x-dashboard::button
                            button-type="submit"
                            class="primary-button justify-center"
                            :title="trans('dashboard::app.customers.customers.view.edit.save-btn')"
                            ::loading="isLoading"
                            ::disabled="isLoading"
                        />
                    </x-slot>
                </x-dashboard::modal>
            </form>
        </x-dashboard::form>

        {!! view_render_event('rehla.dashboard.customers.customers.view.edit.edit_form_controls.after', ['customer' => $customer]) !!}
    </script>

    <script type="module">
        app.component('v-customer-edit', {
            template: '#v-customer-edit-template',

            props: ['customer'],

            emits: ['update-customer'],

            data() {
                return {
                    groups: @json($groups),

                    isLoading: false,
                };
            },

            methods: {
                edit(params, {resetForm, setErrors}) {
                    this.isLoading = true;

                    let formData = new FormData(this.$refs.customerEditForm);

                    formData.append('_method', 'put');

                    this.$axios.post('{{ route('admin.customers.customers.update', $customer->id) }}', formData)
                        .then((response) => {
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                            this.$emit('update-customer', response.data.data);

                            resetForm();

                            this.isLoading = false;

                            this.$refs.customerEditModal.close();
                        })
                        .catch(error => {
                            this.isLoading = false;

                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);
                            }
                        });
                },
            }
        })
    </script>
@endPushOnce
