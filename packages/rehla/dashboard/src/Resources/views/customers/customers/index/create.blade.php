@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-create-customer-form-template"
    >
        <x-dashboard::form
            v-slot="{ meta, errors, handleSubmit }"
            as="div"
        >
            <form @submit="handleSubmit($event, create)">
                <!-- Customer Create Modal -->
                <x-dashboard::modal ref="customerCreateModal">
                    <!-- Modal Header -->
                    <x-slot:header>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">
                            @lang('dashboard::app.customers.customers.index.create.title')
                        </p>
                    </x-slot>

                    <!-- Modal Content -->
                    <x-slot:content>
                        {!! view_render_event('rehla.dashboard.customers.create.before') !!}

                        <div class="flex gap-4 max-sm:flex-wrap">
                            <!-- First Name -->
                            <x-dashboard::form.control-group class="mb-2.5 w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.index.create.first-name')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.index.create.first-name')"
                                    :placeholder="trans('dashboard::app.customers.customers.index.create.first-name')"
                                />

                                <x-dashboard::form.control-group.error control-name="first_name" />
                            </x-dashboard::form.control-group>

                            <!-- Last Name -->
                            <x-dashboard::form.control-group class="mb-2.5 w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.index.create.last-name')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.index.create.last-name')"
                                    :placeholder="trans('dashboard::app.customers.customers.index.create.last-name')"
                                />

                                <x-dashboard::form.control-group.error control-name="last_name" />
                            </x-dashboard::form.control-group>
                        </div>

                        <!-- Email -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.index.create.email')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="email"
                                id="email"
                                name="email"
                                rules="required|email"
                                :label="trans('dashboard::app.customers.customers.index.create.email')"
                                placeholder="email@example.com"
                            />

                            <x-dashboard::form.control-group.error control-name="email" />
                        </x-dashboard::form.control-group>

                        <!-- Contact Number -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.customers.customers.index.create.contact-number')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                id="phone"
                                name="phone"
                                rules="phone"
                                :label="trans('dashboard::app.customers.customers.index.create.contact-number')"
                                :placeholder="trans('dashboard::app.customers.customers.index.create.contact-number')"
                            />

                            <x-dashboard::form.control-group.error control-name="phone" />
                        </x-dashboard::form.control-group>

                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.customers.customers.index.create.date-of-birth')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="date"
                                id="dob"
                                name="date_of_birth"
                                :label="trans('dashboard::app.customers.customers.index.create.date-of-birth')"
                                :placeholder="trans('dashboard::app.customers.customers.index.create.date-of-birth')"
                            />

                            <x-dashboard::form.control-group.error control-name="date_of_birth" />
                        </x-dashboard::form.control-group>

                        <!-- Gender -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.customers.customers.index.create.gender')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="select"
                                id="gender"
                                name="gender"
                                rules="required"
                                :label="trans('dashboard::app.customers.customers.index.create.gender')"
                            >
                                <option value="">
                                    @lang('dashboard::app.customers.customers.index.create.select-gender')
                                </option>

                                <option value="Male">
                                    @lang('dashboard::app.customers.customers.index.create.male')
                                </option>

                                <option value="Female">
                                    @lang('dashboard::app.customers.customers.index.create.female')
                                </option>

                                <option value="Other">
                                    @lang('dashboard::app.customers.customers.index.create.other')
                                </option>
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="gender" />
                        </x-dashboard::form.control-group>

                        <div class="flex gap-4 max-sm:flex-wrap">
                            <!-- Channel -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.customers.customers.index.create.channel')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="select"
                                    id="channel"
                                    name="channel_id"
                                    rules="required"
                                    :label="trans('dashboard::app.customers.customers.index.create.channel')"
                                    ::value="channels[0]?.id"
                                >
                                    <option 
                                        v-for="channel in channels" 
                                        :value="channel.id"
                                        selected
                                    > 
                                        @{{ channel.name }} (@{{ channel.code }})
                                    </option>
                                </x-dashboard::form.control-group.control>

                                <x-dashboard::form.control-group.error control-name="channel_id" />
                            </x-dashboard::form.control-group>

                            <!-- Customer Group -->
                            <x-dashboard::form.control-group class="w-full">
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.customers.customers.index.create.customer-group')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="select"
                                    id="customerGroup"
                                    name="customer_group_id"
                                    :label="trans('dashboard::app.customers.customers.index.create.customer-group')"
                                    ::value="groups[0]?.id"
                                >
                                    <option 
                                        v-for="group in groups" 
                                        :value="group.id"
                                        selected
                                    > 
                                        @{{ group.name }} 
                                    </option>
                                </x-dashboard::form.control-group.control>

                                <x-dashboard::form.control-group.error control-name="customer_group_id" />
                            </x-dashboard::form.control-group>
                        </div>

                        {!! view_render_event('rehla.dashboard.customers.create.after') !!}
                    </x-slot>

                    <!-- Modal Footer -->
                    <x-slot:footer>
                        <!-- Save Button -->
                        <x-dashboard::button
                            button-type="submit"
                            class="primary-button justify-center"
                            :title="trans('dashboard::app.customers.customers.index.create.save-btn')"
                            ::loading="isLoading"
                            ::disabled="isLoading"
                        />
                    </x-slot>
                </x-dashboard::modal>
            </form>
        </x-dashboard::form>
    </script>

    <script type="module">
        app.component('v-create-customer-form', {
            template: '#v-create-customer-form-template',

            data() {
                return {
                    groups: @json($groups),

                    channels: @json($channels),

                    isLoading: false,
                };
            },

            methods: {
                openModal() {
                    this.$refs.customerCreateModal.open();
                },

                create(params, { resetForm, setErrors }) {
                    this.isLoading = true;

                    this.$axios.post("{{ route('admin.customers.customers.store') }}", params)
                        .then((response) => {
                            this.$refs.customerCreateModal.close();

                            this.$emit('customer-created', response.data.data);

                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                            resetForm();

                            this.isLoading = false;
                        })
                        .catch(error => {                            
                            this.isLoading = false;

                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);
                            }
                        });
                }
            }
        })
    </script>
@endPushOnce