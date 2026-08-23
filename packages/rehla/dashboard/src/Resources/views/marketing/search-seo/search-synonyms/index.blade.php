<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.marketing.search-seo.search-synonyms.index.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.marketing.search_seo.search_synonyms.create.before') !!}

    <!-- Create Sitemap Vue Component -->
    <v-create-sitemaps>
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.marketing.search-seo.search-synonyms.index.title')
            </p>

            <!-- Create Button -->
            @if (bouncer()->hasPermission('marketing.search_seo.search_synonyms.create'))
                <div class="primary-button">
                    @lang('dashboard::app.marketing.search-seo.search-synonyms.index.create-btn')
                </div>
            @endif
        </div>

        <!-- Added For Shimmer -->
        <x-dashboard::shimmer.datagrid />
    </v-create-sitemaps>

    {!! view_render_event('rehla.dashboard.marketing.search_seo.search_synonyms.create.after') !!}

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-create-sitemaps-template"
        >
            <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                <p class="text-xl font-bold text-gray-800 dark:text-white">
                    @lang('dashboard::app.marketing.search-seo.search-synonyms.index.title')
                </p>

                <!-- Create Button -->
                @if (bouncer()->hasPermission('marketing.search_seo.search_synonyms.create'))
                    <div
                        class="primary-button"
                        @click="selectedSitemap=0; $refs.sitemap.toggle()"
                    >
                        @lang('dashboard::app.marketing.search-seo.search-synonyms.index.create-btn')
                    </div>
                @endif
            </div>

            {!! view_render_event('rehla.dashboard.marketing.search_seo.search_synonyms.list.before') !!}

            <x-dashboard::datagrid
                :src="route('admin.marketing.search_seo.search_synonyms.index')"
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
                            <!-- Mass Actions -->
                            <p v-if="available.massActions.length">
                                <label :for="`mass_action_select_record_${record[available.meta.primary_column]}`">
                                    <input
                                        type="checkbox"
                                        class="peer hidden"
                                        :name="`mass_action_select_record_${record[available.meta.primary_column]}`"
                                        :value="record[available.meta.primary_column]"
                                        :id="`mass_action_select_record_${record[available.meta.primary_column]}`"
                                        v-model="applied.massActions.indices"
                                    >

                                    <span class="icon-uncheckbox peer-checked:icon-checked cursor-pointer rounded-md text-2xl peer-checked:text-blue-600">
                                    </span>
                                </label>
                            </p>

                            <!-- Id -->
                            <p>@{{ record.id }}</p>

                            <!-- Name -->
                            <p>@{{ record.name }}</p>

                            <!-- Terms -->
                            <p>@{{ record.terms }}</p>

                            <!-- Actions -->
                            <div class="flex justify-end">
                                @if (bouncer()->hasPermission('marketing.search_seo.search_synonyms.edit'))
                                    <a @click="selectedSitemap=1; editModal(record)">
                                        <span
                                            :class="record.actions.find(action => action.index === 'edit')?.icon"
                                            class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-100 dark:hover:bg-gray-950 max-sm:place-self-center"
                                        >
                                        </span>
                                    </a>
                                @endif

                                @if (bouncer()->hasPermission('marketing.search_seo.search_synonyms.delete'))
                                    <a @click="performAction(record.actions.find(action => action.index === 'delete'))">
                                        <span
                                            :class="record.actions.find(action => action.index === 'delete')?.icon"
                                            class="cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-100 dark:hover:bg-gray-950 max-sm:place-self-center"
                                        >
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </template>
                </template>
            </x-dashboard::datagrid>

            {!! view_render_event('admin.marketing.search_seo.search_synonyms.list.after') !!}

            <!-- Model Form -->
            <x-dashboard::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
                ref="modalForm"
            >
                <!-- Create Sitemap form -->
                <form
                    @submit="handleSubmit($event, updateOrCreate)"
                    ref="sitemapCreateForm"
                >
                    <x-dashboard::modal ref="sitemap">
                        <!-- Modal Header -->
                        <x-slot:header>
                            <!-- Create Modal title -->
                            <p
                                class="text-lg font-bold text-gray-800 dark:text-white"
                                v-if="selectedSitemap"
                            >
                                @lang('dashboard::app.marketing.search-seo.search-synonyms.index.edit.title')
                            </p>

                            <!-- Edit Modal title -->
                            <p
                                class="text-lg font-bold text-gray-800 dark:text-white"
                                v-else
                            >
                                @lang('dashboard::app.marketing.search-seo.search-synonyms.index.create.title')
                            </p>
                        </x-slot>

                        <!-- Modal Content -->
                        <x-slot:content>
                            <!-- ID -->
                            <x-dashboard::form.control-group.control
                                type="hidden"
                                name="id"
                            />

                            <!-- Name -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.marketing.search-seo.search-synonyms.index.create.name')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="text"
                                    name="name"
                                    rules="required"
                                    :label="trans('dashboard::app.marketing.search-seo.search-synonyms.index.create.name')"
                                    :placeholder="trans('dashboard::app.marketing.search-seo.search-synonyms.index.create.name')"
                                />

                                <x-dashboard::form.control-group.error control-name="name" />
                            </x-dashboard::form.control-group>

                            <!-- Terms -->
                            <x-dashboard::form.control-group>
                                <x-dashboard::form.control-group.label class="required">
                                    @lang('dashboard::app.marketing.search-seo.search-synonyms.index.create.terms')
                                </x-dashboard::form.control-group.label>

                                <x-dashboard::form.control-group.control
                                    type="textarea"
                                    name="terms"
                                    rules="required"
                                    :label="trans('dashboard::app.marketing.search-seo.search-synonyms.index.create.terms')"
                                    :placeholder="trans('dashboard::app.marketing.search-seo.search-synonyms.index.create.terms')"
                                />

                                <x-dashboard::form.control-group.error control-name="terms" />

                                <p class="mt-2 text-xs font-medium text-gray-600 dark:text-gray-300 ltr:ml-1 rtl:mr-1">
                                    @lang('dashboard::app.marketing.search-seo.search-synonyms.index.create.terms-info')
                                </p>
                            </x-dashboard::form.control-group>
                        </x-slot>

                        <!-- Modal Footer -->
                        <x-slot:footer>
                            <!-- Save Button -->
                            <x-dashboard::button
                                button-type="submit"
                                class="primary-button"
                                :title="trans('dashboard::app.marketing.search-seo.search-synonyms.index.create.save-btn')"
                                ::loading="isLoading"
                                ::disabled="isLoading"
                            />
                        </x-slot>
                    </x-dashboard::modal>
                </form>
            </x-dashboard::form>
        </script>

        <script type="module">
            app.component('v-create-sitemaps', {
                template: '#v-create-sitemaps-template',

                data() {
                    return {
                        selectedSitemap: 0,

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

                        let formData = new FormData(this.$refs.sitemapCreateForm);

                        if (params.id) {
                            formData.append('_method', 'put');
                        }

                        this.$axios.post(params.id ? "{{ route('admin.marketing.search_seo.search_synonyms.update') }}" : "{{ route('admin.marketing.search_seo.search_synonyms.store') }}", formData )
                            .then((response) => {
                                this.isLoading = false;

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                this.$refs.sitemap.toggle();

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

                    editModal(values) {
                        this.$refs.sitemap.toggle();

                        this.$refs.modalForm.setValues(values);
                    },
                },
            })
        </script>
    @endPushOnce
</x-dashboard::layouts>
