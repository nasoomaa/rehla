<x-dashboard::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('dashboard::app.users.sessions.title')
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
                <x-dashboard::form :action="route('admin.session.store')">
                    <p class="p-4 text-xl font-bold text-gray-800 dark:text-white">
                        @lang('dashboard::app.users.sessions.title')
                    </p>

                    <div class="border-y p-4 dark:border-gray-800">
                        <!-- Email -->
                        <x-dashboard::form.control-group>
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.users.sessions.email')
                            </x-dashboard::form.control-group.label>

                            <x-dashboard::form.control-group.control 
                                type="email" 
                                class="w-[254px] max-w-full" 
                                id="email"
                                name="email" 
                                rules="required|email" 
                                :label="trans('dashboard::app.users.sessions.email')"
                                :placeholder="trans('dashboard::app.users.sessions.email')"
                            />

                            <x-dashboard::form.control-group.error control-name="email" />
                        </x-dashboard::form.control-group>

                        <!-- Password -->
                        <x-dashboard::form.control-group class="relative w-full">
                            <x-dashboard::form.control-group.label class="required">
                                @lang('dashboard::app.users.sessions.password')
                            </x-dashboard::form.control-group.label>
                    
                            <x-dashboard::form.control-group.control 
                                type="password" 
                                class="w-[254px] max-w-full ltr:pr-10 rtl:pl-10" 
                                id="password"
                                name="password" 
                                rules="required|min:6" 
                                :label="trans('dashboard::app.users.sessions.password')"
                                :placeholder="trans('dashboard::app.users.sessions.password')"
                            />
                    
                            <span 
                                class="icon-view absolute top-[42px] -translate-y-2/4 cursor-pointer text-2xl ltr:right-2 rtl:left-2"
                                onclick="switchVisibility()"
                                id="visibilityIcon"
                                role="presentation"
                                tabindex="0"
                            >
                            </span>
                    
                            <x-dashboard::form.control-group.error control-name="password" />
                        </x-dashboard::form.control-group>
                    </div>

                    <div class="flex items-center justify-between p-4">
                        <!-- Forgot Password Link -->
                        <a 
                            class="cursor-pointer text-xs font-semibold leading-6 text-blue-600"
                            href="{{ route('admin.forget_password.create') }}"
                        >
                            @lang('dashboard::app.users.sessions.forget-password-link')
                        </a>

                        <!-- Submit Button -->
                        <button
                            class="cursor-pointer rounded-md border border-blue-700 bg-blue-600 px-3.5 py-1.5 font-semibold text-gray-50"
                            aria-label="{{ trans('dashboard::app.users.sessions.submit-btn')}}"
                        >
                            @lang('dashboard::app.users.sessions.submit-btn')
                        </button>
                    </div>
                </x-dashboard::form>
            </div>

            <!-- Powered By -->
            <div class="text-sm font-normal">
                @lang('dashboard::app.users.sessions.powered-by-description', [
                    'bagisto' => '<a class="text-blue-600 hover:underline" href="https://bagisto.com/en/">Bagisto</a>',
                    'webkul' => '<a class="text-blue-600 hover:underline" href="https://webkul.com/">Webkul</a>',
                ])
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function switchVisibility() {
                let passwordField = document.getElementById("password");
                let visibilityIcon = document.getElementById("visibilityIcon");

                passwordField.type = passwordField.type === "password" ? "text" : "password";
                visibilityIcon.classList.toggle("icon-view-close");
            }
        </script>
    @endpush
</x-dashboard::layouts.anonymous>