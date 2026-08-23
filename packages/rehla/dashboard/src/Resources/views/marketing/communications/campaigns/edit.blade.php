<x-dashboard::layouts>
    <x-slot:title>
        @lang('dashboard::app.marketing.communications.campaigns.edit.title')
    </x-slot>

    {!! view_render_event('rehla.dashboard.marketing.communications.campaigns.edit.before', ['campaign' => $campaign]) !!}

    <!-- Input Form -->
    <x-dashboard::form
        :action="route('admin.marketing.communications.campaigns.update', $campaign->id)"
        method="PUT"
    >

        {!! view_render_event('rehla.dashboard.marketing.communications.campaigns.create.create_form_controls.before', ['campaign' => $campaign]) !!}

        <div class="flex items-center justify-between">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('dashboard::app.marketing.communications.campaigns.edit.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.marketing.communications.campaigns.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('dashboard::app.marketing.communications.campaigns.edit.back-btn')
                </a>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('dashboard::app.marketing.communications.campaigns.edit.save-btn')
                </button>
            </div>
        </div>

        <!-- Information -->
        <div class="mb-2 mt-7 flex gap-2.5">
            <!-- Left Section -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">

                {!! view_render_event('rehla.dashboard.marketing.communications.campaigns.edit.card.general.before', ['campaign' => $campaign]) !!}

                <!-- General Section -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('dashboard::app.marketing.communications.campaigns.edit.general')
                    </p>

                    <div class="mb-2.5">
                        <!-- Name -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.marketing.communications.campaigns.edit.name')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="name"
                                rules="required"
                                :value="old('name') ?: $campaign->name"
                                :label="trans('dashboard::app.marketing.communications.campaigns.edit.name')"
                                :placeholder="trans('dashboard::app.marketing.communications.campaigns.edit.name')"
                            />

                            <x-dashboard::form.control-group.error control-name="name" />
                        </x-dashboard::form.control-group>

                        <!-- Subject -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.marketing.communications.campaigns.edit.subject')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="text"
                                name="subject"
                                rules="required"
                                :value="old('subject') ?: $campaign->subject"
                                :label="trans('dashboard::app.marketing.communications.campaigns.edit.subject')"
                                :placeholder="trans('dashboard::app.marketing.communications.campaigns.edit.subject')"
                            />

                            <x-dashboard::form.control-group.error control-name="subject" />
                        </x-dashboard::form.control-group>

                         <!-- Event -->
                         <x-dashboard::form.control-group>
                             <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.marketing.communications.campaigns.edit.event')
                            </x-dashboard::form.control-group.label>

                            @php $selectedOption = old('marketing_event_id') ?: $campaign->marketing_event_id @endphp

                            <x-dashboard::form.control-group.control
                                type="select"
                                class="cursor-pointer"
                                name="marketing_event_id"
                                :value="$selectedOption"
                                rules="required"
                                :label="trans('dashboard::app.marketing.communications.campaigns.edit.event')"
                            >
                                @foreach (app('Webkul\Marketing\Repositories\EventRepository')->all() as $event)
                                    <option
                                        value="{{ $event->id }}"
                                        {{ $selectedOption == $event->id ? 'selected' : '' }}
                                        v-pre
                                    >
                                        {{ $event->name }}
                                    </option>
                                @endforeach
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="marketing_event_id" />
                        </x-dashboard::form.control-group>

                        <!-- Email Template -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.marketing.communications.campaigns.edit.email-template')
                            </x-dashboard::form.control-group.label>

                            @php $selectedOption = old('marketing_template_id') ?: $campaign->marketing_template_id; @endphp

                            <x-dashboard::form.control-group.control
                                type="select"
                                class="cursor-pointer"
                                name="marketing_template_id"
                                rules="required"
                                :value="$selectedOption"
                                :label="trans('dashboard::app.marketing.communications.campaigns.edit.email-template')"
                            >
                                @foreach ($templates as $template)
                                    <option
                                        value="{{ $template->id }}"
                                        {{ $selectedOption == $template->id ? 'selected' : '' }}
                                        v-pre
                                    >
                                        {{ $template->name }}
                                    </option>
                                @endforeach
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="marketing_template_id" />
                        </x-dashboard::form.control-group>
                    </div>
                </div>

                {!! view_render_event('rehla.dashboard.marketing.communications.campaigns.edit.card.general.after', ['campaign' => $campaign]) !!}
            </div>

             <!-- Right Section -->
             <div class="flex w-[360px] max-w-full flex-col gap-2 max-md:w-full">

                {!! view_render_event('rehla.dashboard.marketing.communications.campaigns.edit.card.accordion.setting.before', ['campaign' => $campaign]) !!}

                <!-- Setting -->
                <x-dashboard::accordion>
                    <x-slot:header>
                        <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                            @lang('dashboard::app.marketing.communications.campaigns.create.setting')
                        </p>
                    </x-slot>

                    <x-slot:content>
                         <!-- Channel -->
                         <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.marketing.communications.campaigns.edit.channel')
                            </x-dashboard::form.control-group.label>

                            @php $selectedOption = old('channel_id') ?: $campaign->channel_id; @endphp

                            <x-dashboard::form.control-group.control
                                type="select"
                                class="mb-1 cursor-pointer"
                                name="channel_id"
                                rules="required"
                                :value="$selectedOption"
                                :label="trans('dashboard::app.marketing.communications.campaigns.edit.channel')"
                            >
                                @foreach (app('Rehla\Core\Repositories\ChannelRepository')->all() as $channel)
                                    <option
                                        value="{{ $channel->id }}"
                                        {{ $selectedOption == $channel->id ? 'selected' : '' }}
                                        v-pre
                                    >
                                        {{ core()->getChannelName($channel) }}
                                    </option>
                                @endforeach
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="channel_id" />
                        </x-dashboard::form.control-group>

                        <!-- Customer Group -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.marketing.communications.campaigns.edit.customer-group')
                            </x-dashboard::form.control-group.label>

                            @php $selectedOption = old('customer_group_id') ?: $campaign->customer_group_id @endphp

                            <x-dashboard::form.control-group.control
                                type="select"
                                class="mb-1 cursor-pointer"
                                name="customer_group_id"
                                rules="required"
                                :value="$campaign->customer_group_id"
                                :label="trans('dashboard::app.marketing.communications.campaigns.edit.customer-group')"
                            >
                                @foreach (app('Webkul\Customer\Repositories\CustomerGroupRepository')->all() as $customerGroup)
                                    <option
                                        value="{{ $customerGroup->id }}"
                                        {{ $selectedOption == $customerGroup->id ? 'selected' : '' }}
                                        v-pre
                                    >
                                        {{ $customerGroup->name }}
                                    </option>
                                @endforeach
                            </x-dashboard::form.control-group.control>

                            <x-dashboard::form.control-group.error control-name="customer_group_id" />
                        </x-dashboard::form.control-group>

                        <!-- Status -->
                        <x-dashboard::form.control-group class="!mb-0">
                            <x-dashboard::form.control-group.label>
                                @lang('dashboard::app.marketing.communications.campaigns.edit.status')
                            </x-dashboard::form.control-group.label>

                            @php $selectedOption = old('status') ?: $campaign->status; @endphp

                            <x-dashboard::form.control-group.control
                                type="hidden"
                                name="status"
                                :value="0"
                            />
                            
                            <x-dashboard::form.control-group.control
                                type="switch"
                                name="status"
                                :value="1"
                                :checked="(boolean) $selectedOption"
                                :label="trans('dashboard::app.marketing.communications.campaigns.edit.status')"
                            />

                            <x-dashboard::form.control-group.error control-name="status" />
                        </x-dashboard::form.control-group>
                    </x-slot>
                </x-dashboard::accordion>

                {!! view_render_event('rehla.dashboard.marketing.communications.campaigns.edit.card.accordion.setting.after', ['campaign' => $campaign]) !!}

            </div>
        </div>

        {!! view_render_event('rehla.dashboard.marketing.communications.campaigns.create.create_form_controls.after', ['campaign' => $campaign]) !!}

    </x-dashboard::form>

    {!! view_render_event('rehla.dashboard.marketing.communications.campaigns.edit.after', ['campaign' => $campaign]) !!}

</x-dashboard::layouts>
