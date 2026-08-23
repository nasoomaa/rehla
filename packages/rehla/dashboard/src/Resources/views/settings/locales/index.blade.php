<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.settings.locales.index.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.settings.locales.create.before') !!}

    <v-locales>
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.settings.locales.index.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                @if (bouncer()->hasPermission('settings.locales.create'))
                    <button
                        type="button"
                        class="primary-button"
                    >
                        @lang('dashboard::app.settings.locales.index.create-btn')
                    </button>
                @endif
            </div>
        </div>

        <!-- DataGrid Shimmer -->
        <x-dashboard::shimmer.datagrid />
    </v-locales>

    {!! view_render_event('rehla.dashboard.settings.locales.create.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-locales-template"
        >
            <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                <p class="text-xl font-bold text-gray-800 dark:text-white">
                    @lang('dashboard::app.settings.locales.index.title')
                </p>

                <div class="flex items-center gap-x-2.5">
                    <!-- Locale Create Button -->
                    @if (bouncer()->hasPermission('settings.locales.create'))
                        <button
                            type="button"
                            class="primary-button"
                            @click="selectedLocales=0;resetForm();$refs.localeUpdateOrCreateModal.toggle()"
                        >
                            @lang('dashboard::app.settings.locales.index.create-btn')
                        </button>
                    @endif
                </div>
            </div>

            <x-dashboard::datagrid
                :src="route('admin.settings.locales.index')"
                ref="datagrid"
            >
                <!-- DataGrid Body -->
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

                            <!-- Code -->
                            <p>@{{ record.code }}</p>

                            <!-- Name -->
                            <p>@{{ record.name }}</p>

                            <!-- Direction -->
                            <p>@{{ record.direction }}</p>

                            <!-- Actions -->
                            <div class="flex justify-end">
                                @if (bouncer()->hasPermission('settings.locales.edit'))
                                    <a @click="selectedLocales=1; editModal(record.actions.find(action => action.index === 'edit')?.url)">
                                        <span
                                            :class="record.actions.find(action => action.index === 'edit')?.icon"
                                            class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                        >
                                        </span>
                                    </a>
                                @endif

                                @if (bouncer()->hasPermission('settings.locales.delete'))
                                    <a @click="performAction(record.actions.find(action => action.index === 'delete'))">
                                        <span
                                            :class="record.actions.find(action => action.index === 'delete')?.icon"
                                            class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                        >
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </template>
                </template>
            </x-dashboard::datagrid>

            <x-dashboard::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
                ref="modalForm"
            >
                <form
                    @submit="handleSubmit($event, updateOrCreate)"
                    ref="createLocaleForm"
                >

                    {!! view_render_event('rehla.dashboard.settings.locales.create_form_controls.before') !!}

                    <x-dashboard::modal ref="localeUpdateOrCreateModal">
                        <!-- Modal Header -->
                        <x-slot:header>
                            <p class="text-lg font-bold text-gray-800 dark:text-white">
                                <span v-if="selectedLocales">
                                    @lang('dashboard::app.settings.locales.index.edit.title')
                                </span>

                                <span v-else>
                                    @lang('dashboard::app.settings.locales.index.create.title')
                                </span>
                            </p>
                        </x-slot>

                        <!-- Modal Content -->
                        <x-slot:content>
                            {!! view_render_event('rehla.dashboard.settings.locale.create.before') !!}

                            <x-dashboard::form.control-group.control
                                type="hidden"
                                name="id"
                                v-model="locale.id"
                            />

                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.settings.locales.index.create.code')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    id="code"
                                    name="code"
                                    rules="required"
                                    v-model="locale.code"
                                    :label="trans('dashboard::app.settings.locales.index.create.code')"
                                    :placeholder="trans('dashboard::app.settings.locales.index.create.code')"
                                    ::disabled="locale.id"
                                />

                                <x-dashboard::form.control-group.error control-name="code" />
                            </x-dashboard::form.control-group>

                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.settings.locales.index.create.name')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    id="name"
                                    name="name"
                                    rules="required"
                                    v-model="locale.name"
                                    :label="trans('dashboard::app.settings.locales.index.create.name')"
                                    :placeholder="trans('dashboard::app.settings.locales.index.create.name')"
                                />

                                <x-dashboard::form.control-group.error control-name="name" />
                            </x-dashboard::form.control-group>

                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.settings.locales.index.create.direction')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="select"
                                    id="direction"
                                    name="direction"
                                    rules="required"
                                    v-model="locale.direction"
                                    :label="trans('dashboard::app.settings.locales.index.create.direction')"
                                >
                                    <!-- Default Option -->
                                    <option value="">
                                        @lang('dashboard::app.settings.locales.index.create.select-direction')
                                    </option>

                                    <option
                                        value="ltr"
                                        selected title="Text direction left to right"
                                    >
                                        LTR
                                    </option>

                                    <option
                                        value="rtl"
                                        title="Text direction right to left"
                                    >
                                        RTL
                                    </option>
                                </x-dashboard::form.control-group.control>

                                <x-dashboard::form.control-group.error control-name="direction" />
                            </x-dashboard::form.control-group>

                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.locales.index.create.locale-logo')
                                </x-dashboard::form.control-group.label>

                                <div class="hidden">
                                    <x-dashboard::media.images
                                        name="logo_path"
                                        ::uploaded-images='locale.image'
                                    />
                                </div>

                                <v-media-images
                                    name="logo_path"
                                    :uploaded-images='locale.image'
                                >
                                </v-media-images>

                                <x-dashboard::form.control-group.error control-name="logo_path" />
                            </x-dashboard::form.control-group>

                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                @lang('dashboard::app.settings.locales.index.logo-size')
                            </p>

                            {!! view_render_event('rehla.dashboard.settings.locale.create.after') !!}
                        </x-slot>

                        <!-- Modal Footer -->
                        <x-slot:footer>
                            <!-- Save Button -->
                            <x-dashboard::button
                                button-type="button"
                                class="primary-button"
                                :title="trans('dashboard::app.settings.locales.index.create.save-btn')"
                                ::loading="isLoading"
                                ::disabled="isLoading"
                            />
                        </x-slot>
                    </x-dashboard::modal>

                    {!! view_render_event('rehla.dashboard.settings.locales.create_form_controls.after') !!}

                </form>
            </x-dashboard::form>
        </script>

        <script type="module">
            app.component('v-locales', {
                template: '#v-locales-template',

                data() {
                    return {
                        locale: {
                            image: [],
                        },

                        isLoading: false,

                        selectedLocales: 0,
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
                    updateOrCreate(params, { resetForm, setErrors  }) {
                        this.isLoading = true;

                        let formData = new FormData(this.$refs.createLocaleForm);

                        if (params.id) {
                            formData.append('_method', 'put');
                        }

                        this.$axios.post(params.id ? "{{ route('admin.settings.locales.update') }}" : "{{ route('admin.settings.locales.store') }}", formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then((response) => {
                            this.isLoading = false;

                            this.$refs.localeUpdateOrCreateModal.close();

                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                            this.$refs.datagrid.get();

                            resetForm();
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
                                this.locale = {
                                    ...response.data.data,
                                        image: response.data.data.logo_path
                                        ? [{ id: 'logo_url', url: response.data.data.logo_url }]
                                        : [],
                                };

                                this.$refs.localeUpdateOrCreateModal.toggle();
                            })
                    },

                    resetForm() {
                        this.locale = {
                            image: [],
                        };
                    }
                },
            });
        </script>
    @endPushOnce
</x-dashboard::layouts>
