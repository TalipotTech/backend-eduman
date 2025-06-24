<x-guest-layout>
    <div class="eduman-login-area flex justify-center items-center w-full h-full">
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="eduman-login-wrapper">
                <div class="eduman-login-logo text-center mb-12">
                    <a href="/">
                        <x-application-logo class="h-12 fill-current text-gray-500" />
                    </a>
                </div>

                <div class="eduman-select-field mb-5">
                    <div class="eduman-input-field-style">
                        <div class="single-input-field w-full">
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="{{ __('Email Address') }}" />
                        </div>
                        <span class="input-icon">
                            <i class="fa-light fa-user"></i>
                        </span>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <div class="eduman-select-field mb-5">
                    <div class="eduman-input-field-style eduman-input-field-style-eye">
                        <div class="single-input-field w-full">
                            <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" 
                                placeholder="{{ __('Password') }}" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="eduman-login-footer-forgot mt-4 mb-5">
                    @if (Route::has('password.request'))
                        <a class="text-[16px] inline-block text-themeBlue" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="eduman-login-btn mb-7">
                    <div class="eduman-login-btn-full default-light-theme">
                        <x-primary-button class="btn-primary">{{ __('Log in') }}</x-primary-button>
                    </div>
                </div>

                <div class="eduman-login-footer">
                    <div class="eduman-login-footer-account text-center">
                        <span class="text-[16px] inline-block text-bodyText"></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
