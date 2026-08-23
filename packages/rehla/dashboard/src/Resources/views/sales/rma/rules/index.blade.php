<x-dashboard::layouts>
    <!-- Title -->
    <x-slot:title>
        @lang('dashboard::app.sales.rma.rules.index.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.catalog.rma.rules.list.before') !!}

    <v-rma-rules>
        <!-- DataGrid Shimmer -->
        <x-dashboard::shimmer.datagrid />
    </v-rma-rules>
    {!! view_render_event('rehla.dashboard.catalog.rma.rules.list.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-rma-rules-template"
        >
            <div>
                <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                    <!-- Title -->
                    <p class="text-xl font-bold text-gray-800 dark:text-white">
                        @lang('dashboard::app.sales.rma.rules.index.title')
                    </p>

                    @if (bouncer()->hasPermission('sales.rma.rules.create'))
                        <!-- Create Button -->
                        <div class="flex items-center gap-x-2.5">
                            <button
                                class="primary-button"
                                @click="selectedLocales=0; resetForm(); $refs.rulesModal.toggle()"
                            >
                                @lang('dashboard::app.sales.rma.rules.index.create-btn')
                            </button>
                        </div>
                    @endif
                </div>

                <x-dashboard::datagrid
                    :src="route('admin.sales.rma.rules.index')"
                    ref="datagrid"
                >
                    @php
                        $hasEditPermission = bouncer()->hasPermission('sales.rma.rules.edit');

                        $hasDeletePermission = bouncer()->hasPermission('sales.rma.rules.delete');

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
                            <p v-text="record.name"></p>

                            <!-- Name -->
                            <p v-html="record.status"></p>

                            <!-- Return Period -->
                            <p v-text="record.return_period"></p>

                            <!-- Actions -->
                            <div class="flex justify-end">
                                @if ($hasEditPermission)
                                    <a @click="selectedLocales=1; editModal(record.actions.find(action => action.method === 'GET').url)">
                                        <span
                                            :class="record.actions.find(action => action.title === 'Edit')?.icon"
                                            class="cursor-pointer rounded-md p-1 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                            :title="record.actions.find(action => action.title === 'Edit')?.title"
                                        >
                                        </span>
                                    </a>
                                @endif

                                @if ($hasDeletePermission)
                                    <a @click="performAction(record.actions.find(action => action.method === 'DELETE'))">
                                        <span
                                            :class="record.actions.find(action => action.method === 'DELETE')?.icon"
                                            class="icon-delete cursor-pointer rounded-md p-2 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                            :title="record.actions.find(action => action.method === 'DELETE')?.title"
                                        >
                                        </span>
                                    </a>
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
                        ref="createRulesForm"
                    >
                        {!! view_render_event('rehla.dashboard.catalog.rma.rules.create_form_controls.before') !!}

                            <x-dashboard::modal ref="rulesModal">
                                <!-- Modal Header -->
                                <x-slot:header>
                                    <p v-if="! selectedLocales" class="text-lg font-bold text-gray-800 dark:text-white">
                                        @lang('dashboard::app.sales.rma.rules.create.create-title')
                                    </p>

                                    <p v-else class="text-lg font-bold text-gray-800 dark:text-white">
                                        @lang('dashboard::app.sales.rma.rules.edit.edit-title')
                                    </p>
                                </x-slot>

                                <!-- Modal Content -->
                                <x-slot:content>
                                    {!! view_render_event('rehla.dashboard.catalog.rma.rules.create.before') !!}
                                    <x-dashboard::form.control-group.control
                                        type="hidden"
                                        name="id"
                                        v-model="rules.id"
                                    />

                                    <x-dashboard::form.control-group.label class="font-semibold">
                                        @lang('dashboard::app.sales.rma.rules.create.rule-details')
                                    </x-dashboard::form.control-group.label>

                                    <hr class="mb-2"/>

                                    <!-- Rules Title -->
                                    <x-dashboard::form.control-group>
                                        <x-dashboard::form.control-group.label class="required">
                                            @lang('dashboard::app.sales.rma.rules.create.rules-title')
                                        </x-dashboard::form.control-group.label>

                                        <x-dashboard::form.control-group.control
                                            type="text"
                                            name="name"
                                            rules="required"
                                            :value="old('name')"
                                            v-model="rules.name"
                                            :label="trans('dashboard::app.sales.rma.rules.create.rules-title')"
                                            :placeholder="trans('dashboard::app.sales.rma.rules.create.rules-title')"
                                        />

                                        <x-dashboard::form.control-group.error control-name="name" />
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

                                    <!-- Rules Description -->
                                    <x-dashboard::form.control-group>
                                        <x-dashboard::form.control-group.label class="required">
                                            @lang('dashboard::app.sales.rma.rules.create.rule-description')
                                        </x-dashboard::form.control-group.label>

                                        <x-dashboard::form.control-group.control
                                            type="textarea"
                                            name="description"
                                            rules="required|min:1|max:70"
                                            :value="old('description')"
                                            v-model="rules.description"
                                            :label="trans('dashboard::app.sales.rma.rules.create.rule-description')"
                                            :placeholder="trans('dashboard::app.sales.rma.rules.create.rule-description')"
                                        />

                                        <x-dashboard::form.control-group.error control-name="description" />
                                    </x-dashboard::form.control-group>

                                    <hr/>

                                    <!-- Resolutions Period -->
                                    <x-dashboard::form.control-group.label class="font-semibold mt-4">
                                        @lang('dashboard::app.sales.rma.rules.create.resolutions-period')
                                    </x-dashboard::form.control-group.label>

                                    <hr class="mb-2"/>

                                    <!-- Return Period -->
                                    <x-dashboard::form.control-group>
                                        <x-dashboard::form.control-group.label>
                                            @lang('dashboard::app.sales.rma.rules.index.datagrid.return-period')
                                        </x-dashboard::form.control-group.label>

                                        <x-dashboard::form.control-group.control
                                            type="number"
                                            name="return_period"
                                            rules="min_value:1"
                                            :value="old('return_period')"
                                            v-model="rules.return_period"
                                            :label="trans('dashboard::app.sales.rma.rules.index.datagrid.return-period')"
                                            :placeholder="trans('dashboard::app.sales.rma.rules.index.datagrid.return-period')"
                                        />

                                        <x-dashboard::form.control-group.error control-name="return_period" />
                                    </x-dashboard::form.control-group>

                                    {!! view_render_event('rehla.dashboard.catalog.rma.rules.create.after') !!}
                                </x-slot>

                                <!-- Modal Footer -->
                                <x-slot:footer>
                                    <div class="flex items-center gap-x-2.5">
                                        <!-- Save Button -->
                                        <button
                                            type="submit"
                                            class="primary-button"
                                        >
                                            @lang('dashboard::app.sales.rma.rules.create.save-btn')
                                        </button>
                                    </div>
                                </x-slot>
                            </x-dashboard::modal>


                        {!! view_render_event('rehla.dashboard.catalog.rma.rules.create_form_controls.after') !!}
                    </form>
                </x-dashboard::form>
            </div>
        </script>

        <script type="module">
            app.component('v-rma-rules', {
                template: '#v-rma-rules-template',

                data() {
                    return {
                        rules: {},

                        selectedLocales: 0,
                    }
                },

                methods: {
                    updateOrCreate(params, {
                        resetForm,
                        setErrors
                    }) {
                        let formData = new FormData(this.$refs.createRulesForm);

                        let url;

                        url = `{{ route('admin.sales.rma.rules.store') }}`;

                        if (params.id) {
                            url = '{{ route('admin.sales.rma.rules.update', ':id') }}'.replace(':id', params.id);
                            
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

                                this.$refs.rulesModal.toggle();
                            });
                    },

                    resetForm() {
                        this.rules = {};
                    },
                },
            });
        </script>
    @endPushOnce
</x-dashboard::layouts>
