<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.settings.currencies.index.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.settings.currencies.create.before') !!}

    <v-currencies>
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.settings.currencies.index.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Create Currency Button -->
                @if (bouncer()->hasPermission('settings.currencies.create'))
                    <button
                        type="button"
                        class="primary-button"
                    >
                        @lang('dashboard::app.settings.currencies.index.create-btn')
                    </button>
                @endif
            </div>
        </div>

        <!-- DataGrid Shimmer -->
        <x-dashboard::shimmer.datagrid />
    </v-currencies>

    {!! view_render_event('rehla.dashboard.settings.currencies.create.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-currencies-template"
        >
            <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                <p class="text-xl font-bold text-gray-800 dark:text-white">
                    @lang('dashboard::app.settings.currencies.index.title')
                </p>

                <div class="flex items-center gap-x-2.5">
                    <!-- Create Currency Button -->
                    @if (bouncer()->hasPermission('settings.currencies.create'))
                        <button
                            type="button"
                            class="primary-button"
                            @click="isEditable=0; selectedCurrency={}; $refs.currencyUpdateOrCreateModal.toggle();"
                        >
                            @lang('dashboard::app.settings.currencies.index.create-btn')
                        </button>
                    @endif
                </div>
            </div>

            <x-dashboard::datagrid
                :src="route('admin.settings.currencies.index')"
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
                            <!-- Currency ID -->
                            <p>@{{ record.id }}</p>

                            <!-- Currency Name -->
                            <p>@{{ record.name }}</p>

                            <!-- Currency Code -->
                            <p>@{{ record.code }}</p>

                            <!-- Actions -->
                            <div class="flex justify-end">
                                @if (bouncer()->hasPermission('settings.currencies.edit'))
                                    <a @click="selectedCurrencies=1; editModal(record.actions.find(action => action.index === 'edit')?.url)">
                                        <span
                                            :class="record.actions.find(action => action.index === 'edit')?.icon"
                                            class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                        >
                                        </span>
                                    </a>
                                @endif

                                @if (bouncer()->hasPermission('settings.currencies.delete'))
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

            <!-- Modal Form -->
            <x-dashboard::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
                ref="modalForm"
            >
                <form
                    @submit="handleSubmit($event, updateOrCreate)"
                    ref="currencyCreateForm"
                >
                    <x-dashboard::modal ref="currencyUpdateOrCreateModal">
                        <!-- Modal Header -->
                        <x-slot:header>
                            <p
                                class="text-lg font-bold text-gray-800 dark:text-white"
                                v-if="isEditable"
                            >
                                @lang('dashboard::app.settings.currencies.index.edit.title')
                            </p>

                            <p
                                class="text-lg font-bold text-gray-800 dark:text-white"
                                v-else
                            >
                                @lang('dashboard::app.settings.currencies.index.create.title')
                            </p>
                        </x-slot>

                        <!-- Modal Content -->
                        <x-slot:content>
                            {!! view_render_event('rehla.dashboard.settings.currencies.create.before') !!}

                            <x-dashboard::form.control-group.control
                                type="hidden"
                                name="id"
                                v-model="selectedCurrency.id"
                            />

                            <!-- Code -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.settings.currencies.index.create.code')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="code"
                                    rules="required|min:3|max:3"
                                    ::value="selectedCurrency.code"
                                    :label="trans('dashboard::app.settings.currencies.index.create.code')"
                                    :placeholder="trans('dashboard::app.settings.currencies.index.create.code')"
                                    ::disabled="selectedCurrency.code"
                                />

                                <x-dashboard::form.control-group.error control-name="code" />
                            </x-dashboard::form.control-group>

                            <!-- Name -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.settings.currencies.index.create.name')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="name"
                                    rules="required"
                                    :value="old('name')"
                                    v-model="selectedCurrency.name"
                                    :label="trans('dashboard::app.settings.currencies.index.create.name')"
                                    :placeholder="trans('dashboard::app.settings.currencies.index.create.name')"
                                />

                                <x-dashboard::form.control-group.error control-name="name" />
                            </x-dashboard::form.control-group>

                            <!-- Symbol -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.currencies.index.create.symbol')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="symbol"
                                    :value="old('symbol')"
                                    v-model="selectedCurrency.symbol"
                                    :label="trans('dashboard::app.settings.currencies.index.create.symbol')"
                                    :placeholder="trans('dashboard::app.settings.currencies.index.create.symbol')"
                                />

                                <x-dashboard::form.control-group.error control-name="symbol" />
                            </x-dashboard::form.control-group>

                            <!-- Decimal -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.currencies.index.create.decimal')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="decimal"
                                    :value="old('decimal')"
                                    rules="numeric|between:0,9"
                                    v-model="selectedCurrency.decimal"
                                    :label="trans('dashboard::app.settings.currencies.index.create.decimal')"
                                    :placeholder="trans('dashboard::app.settings.currencies.index.create.decimal')"
                                />

                                <x-dashboard::form.control-group.error control-name="decimal" />
                            </x-dashboard::form.control-group>

                            <!-- Group Separator -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.currencies.index.create.group-separator')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="group_separator"
                                    :value="old('group_separator')"
                                    ::rules="{ regex: /^[,\.' ]$/ }"
                                    v-model="selectedCurrency.group_separator"
                                    :label="trans('dashboard::app.settings.currencies.index.create.group-separator')"
                                    :placeholder="trans('dashboard::app.settings.currencies.index.create.group-separator')"
                                />

                                <p class="mt-1 block text-xs italic leading-5 text-gray-600 dark:text-gray-300">
                                    @lang('dashboard::app.settings.currencies.index.create.group-separator-note', [
                                        'attribute' => trans('dashboard::app.settings.currencies.index.create.group-separator')
                                    ])
                                </p>

                                <x-dashboard::form.control-group.error control-name="group_separator" />
                            </x-dashboard::form.control-group>

                            <!-- Decimal Separator -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.currencies.index.create.decimal-separator')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="decimal_separator"
                                    :value="old('decimal_separator')"
                                    ::rules="{ regex: /^[,\.]+$/ }"
                                    v-model="selectedCurrency.decimal_separator"
                                    :label="trans('dashboard::app.settings.currencies.index.create.decimal-separator')"
                                    :placeholder="trans('dashboard::app.settings.currencies.index.create.decimal-separator')"
                                />

                                <p class="mt-1 block text-xs italic leading-5 text-gray-600 dark:text-gray-300">
                                    @lang('dashboard::app.settings.currencies.index.create.decimal-separator-note', [
                                        'attribute' => trans('dashboard::app.settings.currencies.index.create.decimal-separator')
                                    ])
                                </p>

                                <x-dashboard::form.control-group.error control-name="decimal_separator" />
                            </x-dashboard::form.control-group>

                            <!-- Currency Position -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label>
                                    @lang('dashboard::app.settings.currencies.index.create.currency-position')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="select"
                                    name="currency_position"
                                    v-model="selectedCurrency.currency_position"
                                    :label="trans('dashboard::app.settings.currencies.index.create.currency-position')"
                                >
                                    <option value="">@lang('dashboard::app.settings.taxes.categories.index.create.select')</option>

                                    <option
                                        v-for="(position, key) in positions"
                                        :value="key"
                                        :text="position"
                                        :selected="key == selectedCurrency.currency_position"
                                    >
                                    </option>
                                </x-dashboard::form.control-group.control>

                                <x-dashboard::form.control-group.error control-name="currency_position" />
                            </x-dashboard::form.control-group>

                            {!! view_render_event('rehla.dashboard.settings.currencies.create.after') !!}
                        </x-slot>

                        <!-- Modal Footer -->
                        <x-slot:footer>
                            <!-- Save Button -->
                            <x-dashboard::button
                                button-type="button"
                                class="primary-button"
                                :title="trans('dashboard::app.settings.currencies.index.create.save-btn')"
                                ::loading="isLoading"
                                ::disabled="isLoading"
                            />
                        </x-slot>
                    </x-dashboard::modal>
                </form>
            </x-dashboard::form>
        </script>

        <script type="module">
            app.component('v-currencies', {
                template: '#v-currencies-template',

                data() {
                    return {
                        isEditable: 0,

                        isLoading: false,

                        selectedCurrency: {},

                        positions: @json($currencyPositions),
                    };
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

                        let formData = new FormData(this.$refs.currencyCreateForm);

                        if (params.id) {
                            formData.append('_method', 'put');
                        }

                        this.$axios.post(params.id ? "{{ route('admin.settings.currencies.update') }}" : "{{ route('admin.settings.currencies.store') }}", formData)
                            .then((response) => {
                                this.isLoading = false;

                                this.$refs.currencyUpdateOrCreateModal.close();

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
                        this.isEditable = 1;

                        this.$axios.get(url)
                            .then((response) => {
                                this.selectedCurrency = response.data;

                                this.$refs.currencyUpdateOrCreateModal.toggle();
                            })
                            .catch(error => {
                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                            });
                    },
                }
            })
        </script>
    @endPushOnce
</x-dashboard::layouts>
