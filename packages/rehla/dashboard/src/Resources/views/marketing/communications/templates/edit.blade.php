<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.marketing.communications.templates.edit.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.marketing.communications.templates.edit.before', ['template' => $template]) !!}
    <!-- Input Form -->
    <x-dashboard::form
        :action="route('admin.marketing.communications.email_templates.update', $template->id)"
        method="PUT"
    >

        {!! view_render_event('rehla.dashboard.marketing.communications.templates.edit.edit_form_controls.before', ['template' => $template]) !!}

        <div class="flex items-center justify-between">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.marketing.communications.templates.edit.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.marketing.communications.email_templates.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('dashboard::app.marketing.communications.templates.edit.back-btn')
                </a>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('dashboard::app.marketing.communications.templates.edit.save-btn')
                </button>
            </div>
        </div>

        <!-- body content -->
        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <!-- Left sub-component -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">

                {!! view_render_event('rehla.dashboard.marketing.communications.templates.edit.card.content.before', ['template' => $template]) !!}

                <!--Content -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <div class="w-full">
                        <!-- Template Textarea -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.marketing.communications.templates.create.content')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="textarea"
                                id="content"
                                name="content"
                                rules="required"
                                value="{{ old('content') ?: $template->content }}"
                                :label="trans('dashboard::app.marketing.communications.templates.edit.content')"
                                :placeholder="trans('dashboard::app.marketing.communications.templates.edit.content')"
                                :tinymce="true"
                            />

                            <x-dashboard::form.control-group.error control-name="content" />
                        </x-dashboard::form.control-group>
                    </div>
                </div>

                {!! view_render_event('rehla.dashboard.marketing.communications.templates.edit.card.content.after', ['template' => $template]) !!}

            </div>

            <!-- Right sub-component -->
            <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
                <!-- General -->

                {!! view_render_event('rehla.dashboard.marketing.communications.templates.edit.card.accordion.general.before', ['template' => $template]) !!}

                <div class="box-shadow rounded bg-white dark:bg-gray-900">
                    <x-dashboard::accordion>
                        <x-slot:header>
                            <div class="flex items-center justify-between">
                                <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                    @lang('dashboard::app.marketing.communications.templates.edit.general')
                                </p>
                            </div>
                        </x-slot>

                        <x-slot:content>
                            <div class="mb-2.5 w-full">
                                <!-- Template Name -->
                                <x-dashboard::form.control-group>
                                    <x-dashboard::form.control-group.label class="required">
                                        @lang('dashboard::app.marketing.communications.templates.edit.name')
                                    </x-dashboard::form.control-group.label>

                                    <x-dashboard::form.control-group.control
                                        type="text"
                                        name="name"
                                        rules="required"
                                        value="{{ old('name') ?: $template->name }}"
                                        :label="trans('dashboard::app.marketing.communications.templates.edit.name')"
                                        :placeholder="trans('dashboard::app.marketing.communications.templates.edit.name')"
                                    />

                                    <x-dashboard::form.control-group.error control-name="name" />
                                </x-dashboard::form.control-group>

                                <!-- Template Status -->
                                <x-dashboard::form.control-group>
                                    <x-dashboard::form.control-group.label class="required">
                                        @lang('dashboard::app.marketing.communications.templates.edit.status')
                                    </x-dashboard::form.control-group.label>

                                    @php $selectedOption = old('status') ?: $template->status @endphp

                                    <x-dashboard::form.control-group.control
                                        type="select"
                                        name="status"
                                        rules="required"
                                        :value="$selectedOption"
                                        :label="trans('dashboard::app.marketing.communications.templates.edit.status')"
                                    >
                                        @foreach (['active', 'inactive', 'draft'] as $state)
                                            <option
                                                value="{{ $state }}"
                                            >
                                                @lang('dashboard::app.marketing.communications.templates.edit.' . $state)
                                            </option>
                                        @endforeach
                                    </x-dashboard::form.control-group.control>

                                    <x-dashboard::form.control-group.error control-name="status" />
                                </x-dashboard::form.control-group>
                            </div>
                        </x-slot>
                    </x-dashboard::accordion>
                </div>

                {!! view_render_event('rehla.dashboard.marketing.communications.templates.edit.card.accordion.general.after', ['template' => $template]) !!}

            </div>
        </div>

        {!! view_render_event('rehla.dashboard.marketing.communications.templates.edit.edit_form_controls.before', ['template' => $template]) !!}

    </x-dashboard::form>

    {!! view_render_event('rehla.dashboard.marketing.communications.templates.edit.after', ['template' => $template]) !!}

</x-dashboard::layouts>
