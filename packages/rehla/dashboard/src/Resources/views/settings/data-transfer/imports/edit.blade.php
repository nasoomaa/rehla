<x-dashboard::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('dashboard::app.settings.data-transfer.imports.edit.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.settings.data_transfer.imports.create.before', ['import' => $import]) !!}

    <x-dashboard::form
        :action="route('admin.settings.data_transfer.imports.update', $import->id)"
        method="PUT"
        enctype="multipart/form-data"
    >
        {!! view_render_event('rehla.dashboard.settings.data_transfer.imports.create.create_form_controls.before', ['import' => $import]) !!}

        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.settings.data-transfer.imports.edit.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.settings.data_transfer.imports.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('dashboard::app.settings.data-transfer.imports.edit.back-btn')
                </a>

                <!-- Save Button -->
                <!-- Import Button. Saving now runs the import through to the end on its own, so it is confirmed first. The hidden submit is what is actually pressed, so the form still validates before anything is sent. -->
                <button
                    type="button"
                    class="primary-button"
                    @click="$emitter.emit('open-confirm-modal', {
                        message: '@lang('dashboard::app.settings.data-transfer.imports.create.import-confirmation')',

                        agree: () => $refs['importSubmit'].click()
                    })"
                >
                    @lang('dashboard::app.settings.data-transfer.imports.edit.save-btn')
                </button>

                <button
                    type="submit"
                    class="hidden"
                    ref="importSubmit"
                ></button>
            </div>
        </div>

        <!-- Body Content -->
        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <!-- Left Container -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                {!! view_render_event('rehla.dashboard.settings.data_transfer.imports.create.card.general.before', ['import' => $import]) !!}

                <!-- Setup Import Panel -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('dashboard::app.settings.data-transfer.imports.edit.general')
                    </p>

                    <!-- Type -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label class="required">
                            @lang('dashboard::app.settings.data-transfer.imports.edit.type')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="select"
                            name="type"
                            id="type"
                            :value="old('type') ?? $import->type"
                            ref="importType"
                            rules="required"
                            :label="trans('dashboard::app.settings.data-transfer.imports.edit.type')"
                        >
                            @foreach (config('importers') as $code => $importer)
                                <option 
                                    value="{{ $code }}"
                                    v-pre
                                >
                                    @lang($importer['title'])
                                </option>
                            @endforeach
                        </x-dashboard::form.control-group.control>

                        <!-- Source Sample Download Links -->
                        <div class="flex items-center mt-2.5">
                            <span>
                                @lang('dashboard::app.settings.data-transfer.imports.create.download-sample')
                            </span>

                            <x-dashboard::dropdown>
                                <x-slot:toggle>
                                    <span class="cursor-pointer text-2xl icon-arrow-down"></span>
                                </x-slot>

                                <x-slot:content>
                                    <div class="grid gap-2.5 max-md:my-0">
                                        @foreach ($supportedFormats as $format)
                                            <a
                                                :href="'{{ route('admin.settings.data_transfer.imports.download_sample', ['type' => ':type:', 'format' => ':format:']) }}'.replace(':type:', $refs['importType']?.value).replace(':format:', '{{ $format }}')"
                                                target="_blank"
                                                id="source-sample-link"
                                                class="cursor-pointer text-sm text-blue-600 transition-all hover:underline"
                                            >
                                                {{ strtoupper($format) }}
                                            </a>
                                        @endforeach
                                    </div>
                                </x-slot>
                            </x-dashboard::dropdown>
                        </div>

                        <x-dashboard::form.control-group.error control-name="type" />
                    </x-dashboard::form.control-group>

                    <!-- Images Directory Path -->
                    <x-dashboard::form.control-group>
                        <x-dashboard::form.control-group.label>
                            @lang('dashboard::app.settings.data-transfer.imports.edit.file')
                        </x-dashboard::form.control-group.label>

                        <x-dashboard::form.control-group.control
                            type="file"
                            name="file"
                            :label="trans('dashboard::app.settings.data-transfer.imports.edit.file')"
                        />

                        <!-- Display Existing File -->
                        @if(isset($import) && $import->file_path)
                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                @lang('dashboard::app.settings.data-transfer.imports.edit.current-file'):
                                <a 
                                    href="{{ route('admin.settings.data_transfer.imports.download', $import->id) }}" 
                                    class="cursor-pointer text-sm text-blue-600 transition-all hover:underline"
                                    target="_blank"
                                    v-pre
                                >
                                    {{ basename($import->file_path) }}
                                </a>
                            </div>
                        @endif

                        <x-dashboard::form.control-group.error control-name="file" />
                    </x-dashboard::form.control-group>
                </div>

                <!-- Product Images -->
                @include('dashboard::settings.data-transfer.imports.images')

                {!! view_render_event('rehla.dashboard.settings.data_transfer.imports.create.card.general.after', ['import' => $import]) !!}
            </div>

            <!-- Right Container -->
            <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
                {!! view_render_event('rehla.dashboard.settings.data_transfer.imports.create.card.accordion.settings.before', ['import' => $import]) !!}

                <!-- Settings Panel -->
                <x-dashboard::accordion>
                    <x-slot:header>
                        <div class="flex items-center justify-between">
                            <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('dashboard::app.settings.data-transfer.imports.edit.settings')
                            </p>
                        </div>
                    </x-slot>

                    <x-slot:content>
                        <!-- Action -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.data-transfer.imports.edit.action')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="select"
                                name="action"
                                id="action"
                                :value="old('action') ?? $import->action"
                                rules="required"
                                :label="trans('dashboard::app.settings.data-transfer.imports.edit.action')"
                            >
                                <option value="append">@lang('dashboard::app.settings.data-transfer.imports.edit.create-update')</option>
                                <option value="delete">@lang('dashboard::app.settings.data-transfer.imports.edit.delete')</option>
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="action" />
                        </x-dashboard::form.control-group>

                        <!-- Validation Strategy -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.data-transfer.imports.edit.validation-strategy')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="select"
                                name="validation_strategy"
                                id="validation_strategy"
                                :value="old('validation_strategy') ?? $import->validation_strategy"
                                rules="required"
                                :label="trans('dashboard::app.settings.data-transfer.imports.edit.validation-strategy')"
                            >
                                <option value="stop-on-errors">@lang('dashboard::app.settings.data-transfer.imports.edit.stop-on-errors')</option>
                                <option value="skip-errors">@lang('dashboard::app.settings.data-transfer.imports.edit.skip-errors')</option>
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="validation_strategy" />
                        </x-dashboard::form.control-group>

                        <!-- Allowed Errors -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.data-transfer.imports.edit.allowed-errors')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="allowed_errors"
                                :value="old('allowed_errors') ?? $import->allowed_errors"
                                rules="required"
                                :label="trans('dashboard::app.settings.data-transfer.imports.edit.allowed-errors')"
                                :placeholder="trans('dashboard::app.settings.data-transfer.imports.edit.allowed-errors')"
                            />

                            <x-dashboard::form.control-group.error control-name="allowed_errors" />
                        </x-dashboard::form.control-group>

                        <!-- CSV Field Separator -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.data-transfer.imports.edit.field-separator')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="field_separator"
                                :value="old('field_separator') ?? $import->field_separator"
                                rules="required"
                                :label="trans('dashboard::app.settings.data-transfer.imports.edit.field-separator')"
                                :placeholder="trans('dashboard::app.settings.data-transfer.imports.edit.field-separator')"
                            />

                            <x-dashboard::form.control-group.error control-name="field_separator" />
                        </x-dashboard::form.control-group>

                        <!-- Process In Queue -->
                        <x-dashboard::form.control-group class="!mb-0">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.settings.data-transfer.imports.edit.process-in-queue')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="switch"
                                name="process_in_queue"
                                :value="1"
                                :checked="(boolean) $import->process_in_queue"
                            />

                            <x-dashboard::form.control-group.error control-name="process_in_queue" />
                        </x-dashboard::form.control-group>
                    </x-slot>
                </x-dashboard::accordion>

                {!! view_render_event('rehla.dashboard.settings.data_transfer.imports.create.card.accordion.settings.after', ['import' => $import]) !!}
            </div>
        </div>

        {!! view_render_event('rehla.dashboard.settings.data_transfer.imports.create.create_form_controls.after', ['import' => $import]) !!}
    </x-dashboard::form>
</x-dashboard::layouts>
