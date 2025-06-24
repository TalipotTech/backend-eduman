<x-guest-layout>
  <div class="eduman-login-area flex justify-center items-center w-full h-full">
    <form method="POST" action="{{ route('register') }}">
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
                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" :placeholder="__('First Name')" required autofocus />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>
            <span class="input-icon">
              <i class="fa-light fa-user"></i>
            </span>
          </div>
        </div>
        <div class="eduman-select-field mb-5">
          <div class="eduman-input-field-style">
            <div class="single-input-field w-full">
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" :placeholder="__('Last Name')" required autofocus />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
            <span class="input-icon">
              <i class="fa-light fa-user"></i>
            </span>
          </div>
        </div>
        <div class="eduman-select-field mb-5">
          <div class="eduman-input-field-style">
            <div class="single-input-field w-full">
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" :placeholder="__('Email Address')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <span class="input-icon">
              <i class="fa-light fa-user"></i>
            </span>
          </div>
        </div>
        <div class="eduman-select-field mb-5">
          <div class="eduman-input-field-style eduman-input-field-style-eye">
            <div class="single-input-field w-full">
                <x-text-input id="password" class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required autocomplete="new-password"
                    :placeholder="__('Password')" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
          </div>
        </div>

        <div class="eduman-select-field mb-5">
          <div class="eduman-input-field-style eduman-input-field-style-eye">
            <div class="single-input-field w-full">
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
              type="password"
              name="password_confirmation" required
              :placeholder="__('Confirm Password')" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
          </div>
        </div>

        <div class="eduman-login-btn mb-7">
          <div class="eduman-login-btn-full default-light-theme">
            <x-primary-button class="btn-primary">
                    {{ __('Register') }}
                </x-primary-button>
          </div>
        </div>
        <div class="eduman-login-footer">
          <div class="eduman-login-footer-account text-center">
            <span class="text-[16px] inline-block text-bodyText">{{ __('Already have an account?') }} <a href="{{ route('login') }}"
                class="text-[16px] text-themeBlue">{{ __('Login') }}</a></span>
          </div>
        </div>
      </div>
    </form>
  </div>
</x-guest-layout>
