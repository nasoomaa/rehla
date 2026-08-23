<x-dashboard::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('dashboard::app.users.reset-password.title')
    </x-slot>

    <div class="flex h-[100vh] items-center justify-center">
        <div class="flex flex-col items-center gap-5">
            <!-- Logo -->
            @if ($logo = core()->getConfigData('general.design.admin_logo.logo_image'))
                <img
                    class="h-10 w-[110px]"
                    src="{{ Storage::url($logo) }}"
                    alt="{{ config('app.name') }}"
                />
            @else
                <img
                    class="w-max" 
                    src="{{ bagisto_asset('images/logo.svg') }}"
                    alt="{{ config('app.name') }}"
                />
            @endif

            <div class="box-shadow flex min-w-[300px] flex-col rounded-md bg-white dark:bg-gray-900">
                <!-- Login Form -->
                <x-dashboard::form :action="route('admin.reset_password.store')">
                    <div class="p-4">
                        <p class="text-xl font-bold text-gray-800 dark:text-white">
                            @lang('dashboard::app.users.reset-password.title')
                        </p>
                    </div>

                    <x-dashboard::form.control-group.control
                        type="hidden"
                        name="token"
                        :value="$token"       
                    />

                    <div class="border-y p-4 dark:border-gray-800">
                        <!-- Email -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.users.reset-password.email')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="email"
                                class="w-[254px] max-w-full" 
                                id="email"
                                name="email" 
                                rules="required|email" 
                                :label="trans('dashboard::app.users.reset-password.email')"
                                :placeholder="trans('dashboard::app.users.reset-password.email')"
                            />

                            <x-dashboard::form.control-group.error control-name="email" />
                        </x-dashboard::form.control-group>
                        
                        <!-- Password -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.users.reset-password.password')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="password"
                                class="w-[254px] max-w-full" 
                                id="password"
                                name="password" 
                                rules="required|min:6" 
                                :label="trans('dashboard::app.users.reset-password.password')"
                                :placeholder="trans('dashboard::app.users.reset-password.password')"
                                ref="password"
                            />

                            <x-dashboard::form.control-group.error control-name="password" />
                        </x-dashboard::form.control-group>

                        <!-- Confirm Password -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.users.reset-password.confirm-password')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control
                                type="password"
                                class="w-[254px] max-w-full" 
                                id="password_confirmation"
                                name="password_confirmation"
                                rules="confirmed:@password" 
                                :label="trans('dashboard::app.users.reset-password.confirm-password')"
                                :placeholder="trans('dashboard::app.users.reset-password.confirm-password')"
                                ref="password"
                            />

                            <x-dashboard::form.control-group.error control-name="password_confirmation" />
                        </x-dashboard::form.control-group>
                    </div>

                    <div class="flex items-center justify-between p-4">
                        <!-- Back Button-->
                        <a 
                            class="cursor-pointer text-xs font-semibold leading-6 text-blue-600"
                            href="{{ route('admin.session.create') }}"
                        >
                            @lang('dashboard::app.users.reset-password.back-link-title')
                        </a>

                        <!-- Submit Button -->
                        <button 
                            class="cursor-pointer rounded-md border border-blue-700 bg-blue-600 px-3.5 py-1.5 font-semibold text-gray-50">
                            @lang('dashboard::app.users.reset-password.submit-btn')
                        </button>
                    </div>
                </x-dashboard::form>
            </div>

            <!-- Powered By -->
            <div class="text-sm font-normal">
                @lang('dashboard::app.users.reset-password.powered-by-description', [
                    'bagisto' => '<a class="text-blue-600 hover:underline" href="https://bagisto.com/en/">Bagisto</a>',
                    'webkul' => '<a class="text-blue-600 hover:underline" href="https://webkul.com/">Webkul</a>',
                ])
            </div>
        </div>
    </div>
</x-dashboard::layouts.anonymous>