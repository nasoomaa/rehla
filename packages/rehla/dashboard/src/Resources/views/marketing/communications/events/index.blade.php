<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.marketing.communications.events.index.title')
    </x-slot>

    <v-events>
        <div class="flex justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.marketing.communications.events.index.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Create Button -->
                @if (bouncer()->hasPermission('marketing.communications.events.create'))
                    <div class="primary-button">
                        @lang('dashboard::app.marketing.communications.events.index.create-btn')
                    </div>
                @endif
            </div>
        </div>

        <!-- DataGrid Shimmer -->
        <x-dashboard::shimmer.datagrid />
    </v-events>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-events-template"
        >
            <div class="flex justify-between gap-4 max-sm:flex-wrap">
                <p class="text-xl font-bold text-gray-800 dark:text-white">
                    @lang('dashboard::app.marketing.communications.events.index.title')
                </p>

                <div class="flex items-center gap-x-2.5">
                    <!-- Create Button -->
                    @if (bouncer()->hasPermission('marketing.communications.events.create'))
                        <div
                            class="primary-button"
                            @click="selectedEvents={}; $refs.emailEvents.toggle()"
                        >
                            @lang('dashboard::app.marketing.communications.events.index.create-btn')
                        </div>
                    @endif
                </div>
            </div>

            {!! view_render_event('rehla.dashboard.marketing.communications.events.list.before') !!}

            <x-dashboard::datagrid
                :src="route('admin.marketing.communications.events.index')"
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
                        <!-- Id -->
                        <p>@{{ record.id }}</p>

                        <!-- Status -->
                        <p>@{{ record.name }}</p>

                        <!-- Email -->
                        <p>@{{ record.date }}</p>

                            <!-- Actions -->
                            @if (
                                bouncer()->hasPermission('marketing.communications.events.edit')
                                || bouncer()->hasPermission('marketing.communications.events.delete')
                            )
                                <div class="flex justify-end">
                                    @if (bouncer()->hasPermission('marketing.communications.events.edit'))
                                        <a @click="id=1; editModal(record.actions.find(action => action.index === 'edit')?.url)">
                                            <span
                                                :class="record.actions.find(action => action.index === 'edit')?.icon"
                                                class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                                :title="record.actions.find(action => action.title === '@lang('dashboard::app.marketing.communications.events.index.datagrid.edit')')?.title"
                                            >
                                            </span>
                                        </a>
                                    @endif

                                    @if (bouncer()->hasPermission('marketing.communications.events.delete'))
                                        <a @click="performAction(record.actions.find(action => action.index === 'delete'))">
                                            <span
                                                :class="record.actions.find(action => action.index === 'delete')?.icon"
                                                class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                                :title="record.actions.find(action => action.title === '@lang('dashboard::app.marketing.communications.events.index.datagrid.delete')')?.title"
                                            >
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </template>
                </template>
            </x-dashboard::datagrid>

            {!! view_render_event('rehla.dashboard.marketing.communications.events.list.after') !!}

            {!! view_render_event('rehla.dashboard.marketing.communications.events.create.before') !!}

            <!-- Email Events form -->
            <x-dashboard::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
                ref="modalForm"
            >
                <form
                    @submit="handleSubmit($event, updateOrCreate)"
                    ref="eventCreateForm"
                >

                    {!! view_render_event('rehla.dashboard.marketing.communications.events.create_form_controls.before') !!}

                    <x-dashboard::modal ref="emailEvents">
                        <!-- Modal Header -->
                        <x-slot:header>
                            <p
                                class="text-lg font-bold text-gray-800 dark:text-white"
                                v-if="selectedEvents"
                            >
                                @lang('dashboard::app.marketing.communications.events.index.create.title')
                            </p>

                            <p
                                class="text-lg font-bold text-gray-800 dark:text-white"
                                v-else
                            >
                                @lang('dashboard::app.settings.users.index.create.title')
                            </p>
                        </x-slot>

                        <!-- Modal Content -->
                        <x-slot:content>
                            <!-- ID -->
                            <x-dashboard::form.control-group.control
                                type="hidden"
                                name="id"
                                v-model="selectedEvents.id"
                            />

                            <!-- Event Name -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.marketing.communications.events.index.create.name')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="name"
                                    rules="required"
                                    :value="old('name')"
                                    v-model="selectedEvents.name"
                                    :label="trans('dashboard::app.marketing.communications.events.index.create.name')"
                                    :placeholder="trans('dashboard::app.marketing.communications.events.index.create.name')"
                                />

                                <x-dashboard::form.control-group.error control-name="name" />
                            </x-dashboard::form.control-group>

                            <!-- Event Description -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.marketing.communications.events.index.create.description')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="textarea"
                                    class="h-[100px]"
                                    id="description"
                                    name="description"
                                    rules="required"
                                    :value="old('description')"
                                    v-model="selectedEvents.description"
                                    :label="trans('dashboard::app.marketing.communications.events.index.create.description')"
                                />

                                <x-dashboard::form.control-group.error control-name="description" />
                            </x-dashboard::form.control-group>

                            <!-- Event Date -->
                            <x-dashboard::form.control-group class="!mb-0">
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.marketing.communications.events.index.create.date')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="date"
                                    class="cursor-pointer"
                                    name="date"
                                    rules="required"
                                    :value="old('date')"
                                    v-model="selectedEvents.date"
                                    :label="trans('dashboard::app.marketing.communications.events.index.create.date')"
                                    :placeholder="trans('dashboard::app.marketing.communications.events.index.create.date')"
                                />

                                <x-dashboard::form.control-group.error control-name="date" />
                            </x-dashboard::form.control-group>
                        </x-slot>

                        <!-- Modal Footer -->
                        <x-slot:footer>
                            <!-- Save Button -->
                            <x-dashboard::button
                                button-type="button"
                                class="primary-button"
                                :title="trans('dashboard::app.marketing.communications.events.index.create.save-btn')"
                                ::loading="isLoading"
                                ::disabled="isLoading"
                            />
                        </x-slot>
                    </x-dashboard::modal>

                    {!! view_render_event('rehla.dashboard.marketing.communications.events.create_form_controls.after') !!}

                </form>
            </x-dashboard::form>

            {!! view_render_event('rehla.dashboard.marketing.communications.events.create.after') !!}

        </script>

        <script type="module">
            app.component('v-events', {
                template: '#v-events-template',

                data() {
                    return {
                        selectedEvents: {},

                        isLoading: false,
                    }
                },

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
                    updateOrCreate(params, { resetForm, setErrors }) {
                        this.isLoading = true;

                        let formData = new FormData(this.$refs.eventCreateForm);

                        if (params.id) {
                            formData.append('_method', 'put');
                        }

                        this.$axios.post(params.id ? "{{ route('admin.marketing.communications.events.update')}}" : "{{ route('admin.marketing.communications.events.store') }}", formData)
                            .then((response) => {
                                this.isLoading = false;

                                this.$refs.emailEvents.toggle();

                                this.$refs.datagrid.get();

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                            })
                            .catch(error => {
                                this.isLoading = false;

                                if (error.response.status == 422) {
                                    setErrors(error.response.data.errors);
                                }
                            });
                    },

                    editModal(url) {
                        this.$axios.get(url)
                            .then((response) => {
                                if (response.data.id) {
                                    this.selectedEvents = response.data;

                                    this.$refs.emailEvents.toggle();
                                } else {
                                    this.$emitter.emit('add-flash', { type: 'error', message: response.data.message });
                                }
                            })
                            .catch(error => this.$emitter.emit('add-flash', {
                                type: 'error', message: error.response.data.message
                            }));
                    },
                }
            })
        </script>
    @endPushOnce
</x-dashboard::layouts>
