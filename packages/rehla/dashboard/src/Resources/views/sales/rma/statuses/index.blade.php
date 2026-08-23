<x-dashboard::layouts>
    <!-- Title -->
    <x-slot:title>
        @lang('dashboard::app.sales.rma.rma-status.index.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.catalog.rma.rma-status.list.before') !!}

    <v-rma-status>
        <!-- DataGrid Shimmer -->
        <x-dashboard::shimmer.datagrid />
    </v-rma-status>
    {!! view_render_event('rehla.dashboard.catalog.rma.rma-status.list.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-rma-status-template"
        >
            <div>
                <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                    <!-- Title -->
                    <p class="text-xl font-bold text-gray-800 dark:text-white">
                        @lang('dashboard::app.sales.rma.rma-status.index.title')
                    </p>

                    @if (bouncer()->hasPermission('sales.rma.statuses.create'))
                        <!-- Create Button -->
                        <div class="flex items-center gap-x-2.5">
                            <button
                                class="primary-button"
                                @click="selectedRules=0; resetForm(); $refs.rulesModal.toggle()"
                            >
                                @lang('dashboard::app.sales.rma.rma-status.index.create-btn')
                            </button>
                        </div>
                    @endif
                </div>

                <x-dashboard::datagrid
                    :src="route('admin.sales.rma.statuses.index')"
                    ref="datagrid"
                >
                    @php
                        $hasEditPermission = bouncer()->hasPermission('sales.rma.statuses.edit');

                        $hasDeletePermission = bouncer()->hasPermission('sales.rma.statuses.delete');

                        $hasPermission = $hasEditPermission || $hasDeletePermission;
                    @endphp

                    <!-- DataGrid Body -->
                    <template #body="{
                        isLoading,
                        available,
                        applied,
                        selectAll,
                        sort,
                        performAction
                    }">
                        <div
                            v-for="record in available.records"
                            class="row grid items-center gap-2.5 border-b px-4 py-4 text-gray-600 transition-all hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-gray-950"
                            :style="'grid-template-columns: repeat(' + (record.actions.length ? 6 : 4) + ', 1fr);'"
                        >
                            @if ($hasPermission)
                                <input
                                    type="checkbox"
                                    :name="`mass_action_select_record_${record.id}`"
                                    :id="`mass_action_select_record_${record.id}`"
                                    :value="record.id"
                                    class="peer hidden"
                                    v-model="applied.massActions.indices"
                                    @change="setCurrentSelectionMode"
                                >

                                <label
                                    class="icon-uncheckbox peer-checked:icon-checked cursor-pointer rounded-md text-2xl peer-checked:text-blue-600"
                                    :for="`mass_action_select_record_${record.id}`"
                                >
                                </label>
                            @endif

                            <!-- ID -->
                            <p v-text="record.id"></p>

                            <!-- Code -->
                            <p v-text="record.title"></p>

                            <!-- Color -->
                            <p v-html="record.color"></p>

                            <!-- Status -->
                            <p v-html="record.status"></p>

                            <!-- Actions -->
                            <div class="flex justify-end">
                                @if ($hasEditPermission)
                                    <a @click="selectedRules=1; editModal(record.actions.find(action => action.method === 'GET').url)">
                                        <span
                                            :class="record.actions.find(action => action.title === 'Edit')?.icon"
                                            class="cursor-pointer rounded-md p-1 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                            :title="record.actions.find(action => action.title === 'Edit')?.title"
                                        >
                                        </span>
                                    </a>
                                @endif

                                @if ($hasDeletePermission)
                                    <span v-if="record.default != 1">
                                        <a @click="performAction(record.actions.find(action => action.method === 'DELETE'))">
                                            <span
                                                :class="record.actions.find(action => action.method === 'DELETE')?.icon"
                                                class="icon-delete cursor-pointer rounded-md p-2 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                                :title="record.actions.find(action => action.method === 'DELETE')?.title"
                                            >
                                            </span>
                                        </a>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </template>
                </x-dashboard::datagrid>

                <!-- Modal Component -->
                <x-dashboard::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                    ref="modalForm"
                >
                    <form
                        @submit="handleSubmit($event, updateOrCreate)"
                        ref="createRmaStatusForm"
                    >
                        {!! view_render_event('rehla.dashboard.catalog.rma.rma-status.create_form_controls.before') !!}

                            <x-dashboard::modal ref="rulesModal">
                                <!-- Modal Header -->
                                <x-slot:header>
                                    <p v-if="! selectedRules" class="text-lg font-bold text-gray-800 dark:text-white">
                                        @lang('dashboard::app.sales.rma.rma-status.create.create-title')
                                    </p>

                                    <p v-else class="text-lg font-bold text-gray-800 dark:text-white">
                                        @lang('dashboard::app.sales.rma.rma-status.edit.edit-title')
                                    </p>
                                </x-slot>

                                <!-- Modal Content -->
                                <x-slot:content>
                                    {!! view_render_event('rehla.dashboard.catalog.rma.rma-status.create.before') !!}

                                    <x-dashboard::form.control-group.control
                                        type="hidden"
                                        name="id"
                                        v-model="rules.id"
                                    />

                                    <div v-if="! selectedRules">
                                        <!-- Status Title -->
                                        <x-dashboard::form.control-group>
                                            <x-dashboard::form.control-group.label class="required">
                                                @lang('dashboard::app.customers.reviews.index.datagrid.title')
                                            </x-dashboard::form.control-group.label>

                                            <x-dashboard::form.control-group.control
                                                type="text"
                                                name="title"
                                                rules="required"
                                                :value="old('title')"
                                                v-model="rules.title"
                                                :label="trans('dashboard::app.customers.reviews.index.datagrid.title')"
                                                :placeholder="trans('dashboard::app.customers.reviews.index.datagrid.title')"
                                            />

                                            <x-dashboard::form.control-group.error control-name="title" />
                                        </x-dashboard::form.control-group>

                                        <!-- Status -->
                                        <x-dashboard::form.control-group>
                                            <x-dashboard::form.control-group.label>
                                                @lang('dashboard::app.sales.rma.reasons.create.status')
                                            </x-dashboard::form.control-group.label>

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="0"
                                            />

                                            <x-dashboard::form.control-group.control
                                                type="switch"
                                                name="status"
                                                value="1"
                                                :label="trans('dashboard::app.sales.rma.rules.create.status')"
                                                ::checked="(rules.status == 1) ? 1 : 0"
                                            />
                                        </x-dashboard::form.control-group>
                                    </div>

                                    <div v-else>
                                        <!-- Status Title -->
                                        <x-dashboard::form.control-group>
                                            <x-dashboard::form.control-group.label class="required">
                                                @lang('dashboard::app.customers.reviews.index.datagrid.title')
                                            </x-dashboard::form.control-group.label>

                                            <x-dashboard::form.control-group.control
                                                type="text"
                                                name="title"
                                                rules="required"
                                                :value="old('title')"
                                                v-model="rules.title"
                                                :label="trans('dashboard::app.customers.reviews.index.datagrid.title')"
                                                :placeholder="trans('dashboard::app.customers.reviews.index.datagrid.title')"
                                                ::readOnly="defaultStatus == 1"
                                            />

                                            <x-dashboard::form.control-group.error control-name="title" />
                                        </x-dashboard::form.control-group>

                                        <!-- Status -->
                                        <div v-if="defaultStatus == 1">
                                            <x-dashboard::form.control-group>
                                                <x-dashboard::form.control-group.label>
                                                    @lang('dashboard::app.sales.rma.reasons.create.status')
                                                </x-dashboard::form.control-group.label>

                                                <p
                                                    v-if="rules.status == 1"
                                                    class="label-active"
                                                >
                                                    @lang('dashboard::app.sales.rma.reasons.index.datagrid.enabled')
                                                </p>

                                                <p
                                                    v-else
                                                    class="label-canceled"
                                                >
                                                    @lang('dashboard::app.sales.rma.reasons.index.datagrid.disabled')
                                                </p>

                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="0"
                                                />

                                                <x-dashboard::form.control-group.control
                                                    type="hidden"
                                                    name="status"
                                                    value="1"
                                                    :label="trans('dashboard::app.sales.rma.rules.create.status')"
                                                    ::checked="(rules.status == 1) ? 1 : 0"
                                                />
                                            </x-dashboard::form.control-group>
                                        </div>

                                        <!-- Status -->
                                        <div v-else>
                                            <x-dashboard::form.control-group>
                                                <x-dashboard::form.control-group.label>
                                                    @lang('dashboard::app.sales.rma.reasons.create.status')
                                                </x-dashboard::form.control-group.label>

                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="0"
                                                />

                                                <x-dashboard::form.control-group.control
                                                    type="switch"
                                                    name="status"
                                                    value="1"
                                                    :label="trans('dashboard::app.sales.rma.rules.create.status')"
                                                    ::checked="(rules.status == 1) ? 1 : 0"
                                                />
                                            </x-dashboard::form.control-group>
                                        </div>
                                    </div>

                                     <!-- Color -->
                                    <x-dashboard::form.control-group class="w-2/6">
                                        <x-dashboard::form.control-group.label>
                                            @lang('dashboard::app.catalog.attributes.create.color')
                                        </x-dashboard::form.control-group.label>

                                        <x-dashboard::form.control-group.control
                                            type="color"
                                            name="color"
                                            rules="required"
                                            v-model="rules.color"
                                            :placeholder="trans('dashboard::app.catalog.attributes.create.color')"
                                        />

                                        <x-dashboard::form.control-group.error control-name="color" />
                                    </x-dashboard::form.control-group>

                                    {!! view_render_event('rehla.dashboard.catalog.rma.rma-status.create.after') !!}
                                </x-slot>

                                <!-- Modal Footer -->
                                <x-slot:footer>
                                    <div class="flex items-center gap-x-2.5">
                                        <!-- Save Button -->
                                        <button
                                            type="submit"
                                            class="primary-button"
                                        >
                                            @lang('dashboard::app.sales.rma.rma-status.create.save-btn')
                                        </button>
                                    </div>
                                </x-slot>
                            </x-dashboard::modal>

                        {!! view_render_event('rehla.dashboard.catalog.rma.rma-status.create_form_controls.after') !!}
                    </form>
                </x-dashboard::form>
            </div>
        </script>

        <script type="module">
            app.component('v-rma-status', {
                template: '#v-rma-status-template',

                data() {
                    return {
                        rules: {},

                        defaultStatus: '',

                        selectedRules: 0,
                    }
                },

                methods: {
                    updateOrCreate(params, {
                        resetForm,
                        setErrors
                    }) {
                        let formData = new FormData(this.$refs.createRmaStatusForm);

                        let url;

                        url = `{{ route('admin.sales.rma.statuses.store') }}`;

                        if (params.id) {
                            url = '{{ route('admin.sales.rma.statuses.update', ':id') }}'.replace(':id', params.id);

                            formData.append('_method', 'put');
                        }

                        this.$axios.post(url, formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then((response) => {
                                this.$refs.rulesModal.close();

                                this.$emitter.emit('add-flash', {
                                    type: 'success',
                                    message: response.data.message
                                });

                                this.$refs.datagrid.get();

                                resetForm();
                            })
                            .catch(error => {
                                if (error.response.status == 422) {
                                    setErrors(error.response.data.errors);
                                }
                            });
                    },

                    editModal(url) {
                        this.$axios.get(url)
                            .then((response) => {
                                this.rules = response.data;

                                this.defaultStatus = response.data.default;

                                this.$refs.rulesModal.toggle();
                            });
                    },

                    resetForm() {
                        this.reason = {};

                        this.reasonResolutions = [];
                        
                        this.rules = {
                            color: '#000000'
                        };
                    },
                },
            });
        </script>
    @endPushOnce
</x-dashboard::layouts>
