<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.customers.gdpr.index.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="py-3 text-xl font-bold text-gray-800 dark:text-white">
            @lang('dashboard::app.customers.gdpr.index.title')
        </p>

        <x-dashboard::datagrid.export src="{{ route('admin.customers.gdpr.index') }}" />
    </div>

    {!! view_render_event('rehla.dashboard.customers.gdpr.list.before') !!}

    <v-create-gdpr></v-create-gdpr>

    {!! view_render_event('rehla.dashboard.customers.gdpr.list.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-create-gdpr-template"
        >
            <div>
                <x-dashboard::datagrid
                    src="{{ route('admin.customers.gdpr.index') }}"
                    ref="datagrid"
                >
                    <template #body="{
                        isLoading,
                        available,
                        applied,
                        selectAll,
                        sort,
                        performAction
                    }">
                        <template v-if="isLoading">
                            <x-dashboard::shimmer.datagrid.table.body />
                        </template>

                        <template v-else>
                            <div
                                v-for="record in available.records"
                                class="row grid items-center gap-2.5 border-b px-4 py-4 text-gray-600 transition-all hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-gray-950"
                                :style="`grid-template-columns: repeat(${gridsCount}, minmax(0, 1fr))`"
                            >
                                <!-- ID -->
                                <p>@{{ record.id }}</p>

                                <!-- Customer Name -->
                                <p>@{{ record.customer_name }}</p>

                                <!-- Status -->
                                <p v-html="record.status"></p>

                                <!-- Type -->
                                <p>@{{ record.type }}</p>

                                <!-- Message -->
                                <p>@{{ record.message }}</p>

                                <!-- Created At -->
                                <p>@{{ record.created_at }}</p>

                                <!-- Actions -->
                                <div class="flex justify-end">
                                    @if (bouncer()->hasPermission('customers.gdpr_requests.edit'))
                                        <a @click="editModal(record.actions.find(action => action.index === 'edit')?.url, record.id)">
                                            <span
                                                :class="record.actions.find(action => action.index === 'edit')?.icon"
                                                class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                                :title="record.actions.find(action => action.title === '@lang('dashboard::app.customers.gdpr.index.datagrid.edit')')?.title"
                                            >
                                            </span>
                                        </a>
                                    @endif

                                    @if (bouncer()->hasPermission('customers.gdpr_requests.delete'))
                                        <a @click="performAction(record.actions.find(action => action.index === 'delete'))">
                                            <span
                                                :class="record.actions.find(action => action.index === 'delete')?.icon"
                                                class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                                :title="record.actions.find(action => action.title === '@lang('dashboard::app.customers.gdpr.index.datagrid.delete')')?.title"
                                            >
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </template>
                    </template>
                </x-dashboard::datagrid>

                {!! view_render_event('rehla.dashboard.customers.groups.list.after') !!}

                <!-- Modal Form -->
                <x-dashboard::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                    ref="modalForm"
                >
                    <form
                        @submit="handleSubmit($event, update)"
                        ref="gdprForm"
                    >
                        <!-- Create Group Modal -->
                        <x-dashboard::modal ref="gdprUpdateModal">
                            <!-- Modal Header -->
                            <x-slot:header>
                                <p class="text-lg font-bold text-gray-800 dark:text-white">
                                    @lang('dashboard::app.customers.gdpr.index.modal.title')
                                </p>
                            </x-slot>

                            <!-- Modal Content -->
                            <x-slot:content>
                                <!-- Status -->
                                <x-dashboard::form.control-group>
                                    <x-dashboard::form.control-group.label class="required">
                                        @lang('dashboard::app.customers.gdpr.index.modal.status')
                                    </x-dashboard::form.control-group.label>

                                    <x-dashboard::form.control-group.control
                                        type="hidden"
                                        name="id"
                                    />

                                    <x-dashboard::form.control-group.control
                                        type="select"
                                        id="status"
                                        name="status"
                                        rules="required"
                                        :label="trans('dashboard::app.customers.gdpr.index.modal.status')"
                                        :placeholder="trans('dashboard::app.customers.gdpr.index.modal.status')"
                                    >
                                        <option value="pending" selected>
                                            @lang('dashboard::app.customers.gdpr.index.modal.pending')
                                        </option>

                                        <option value="processing">
                                            @lang('dashboard::app.customers.gdpr.index.modal.processing')
                                        </option>
                                        
                                        <option value="declined">
                                            @lang('dashboard::app.customers.gdpr.index.modal.declined')
                                        </option>

                                        <option value="completed">
                                            @lang('dashboard::app.customers.gdpr.index.modal.completed')
                                        </option>

                                        <option value="revoked">
                                            @lang('dashboard::app.customers.gdpr.index.modal.revoked')
                                        </option>
                                    </x-dashboard::form.control-group.control>

                                    <x-dashboard::form.control-group.error control-name="status" />
                                </x-dashboard::form.control-group>

                                <!-- Type -->
                                <x-dashboard::form.control-group>
                                    <x-dashboard::form.control-group.label class="required">
                                        @lang('dashboard::app.customers.gdpr.index.modal.type')
                                    </x-dashboard::form.control-group.label>

                                    <x-dashboard::form.control-group.control
                                        type="hidden"
                                        name="type"
                                    />

                                    <x-dashboard::form.control-group.control
                                        type="text"
                                        id="type"
                                        name="type"
                                        rules="required"
                                        :label="trans('dashboard::app.customers.gdpr.index.modal.type')"
                                        :placeholder="trans('dashboard::app.customers.gdpr.index.modal.type')"
                                        disabled
                                    />

                                    <x-dashboard::form.control-group.error control-name="type" />
                                </x-dashboard::form.control-group>

                                <!-- Message -->
                                <x-dashboard::form.control-group>
                                    <x-dashboard::form.control-group.label class="required">
                                        @lang('dashboard::app.customers.gdpr.index.modal.message')
                                    </x-dashboard::form.control-group.label>

                                    <x-dashboard::form.control-group.control
                                        type="textarea"
                                        id="message"
                                        name="message"
                                        rules="required"
                                        :label="trans('dashboard::app.customers.gdpr.index.modal.message')"
                                        :placeholder="trans('dashboard::app.customers.gdpr.index.modal.message')"
                                    />

                                    <x-dashboard::form.control-group.error control-name="message" />
                                </x-dashboard::form.control-group>
                            </x-slot>

                            <!-- Modal Footer -->
                            <x-slot:footer>
                                <div class="flex items-center gap-x-2.5">
                                    <button
                                        type="submit"
                                        class="primary-button"
                                    >
                                        @lang('dashboard::app.customers.gdpr.index.modal.save-btn')
                                    </button>
                                </div>
                            </x-slot>
                        </x-dashboard::modal>
                    </form>
                </x-dashboard::form>
            </div>
        </script>

        <script type="module">
            app.component('v-create-gdpr', {
                template: '#v-create-gdpr-template',

                computed: {
                    gridsCount() {
                        let count = this.$refs.datagrid.available.columns.length;

                        if (this.$refs.datagrid.available.actions.length) {
                            ++count;
                        }

                        if (this.$refs.datagrid.available.massActions.length) {
                            ++count;
                        }

                        return count;
                    },
                },

                methods: {
                    update(params) {
                        const formData = new FormData(this.$refs.gdprForm);

                        if (params.id) {
                            formData.append('_method', 'put');
                        }

                        this.$axios.post('{{ route('admin.customers.gdpr.update', ':id') }}'.replace(':id', params.id), formData)
                            .then((response) => {
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                            })
                            .catch((error) => {
                                this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                            })
                            .finally(() => {
                                this.$refs.gdprUpdateModal.close();

                                this.$refs.datagrid.get();
                            });
                    },

                    editModal(url, id) {
                        this.$axios.get(url, { params: { id } })
                            .then((response) => {
                                this.$refs.gdprUpdateModal.toggle();

                                this.$refs.modalForm.setValues(response.data.data);
                            })
                    },
                }
            })
        </script>
    @endPushOnce

</x-dashboard::layouts>
