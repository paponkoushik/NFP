<x-guest-layout>
    <x-slot:title>Reset Password</x-slot>

        <x-auth-card layout="cover">
            <x-slot name="coverImg">
                <img src="{{ asset('assets/img/illustrations/boy-with-laptop-light.png') }}" class="img-fluid"
                     alt="Login image" width="700" data-app-dark-img="illustrations/boy-with-laptop-dark.png"
                     data-app-light-img="illustrations/boy-with-laptop-light.png">
            </x-slot>

            <h4 class="mb-3">Reset Password 🔒</h4>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors"/>

            <form method="POST" class="mb-3" action="{{ route('password.update') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

                <!-- Password -->
                <div class="mb-2">
                    <x-label for="password" :value="__('Password')"/>

                    <x-input.text id="password" type="password" name="password"
                                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                  required/>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <x-label for="password_confirmation" :value="__('Confirm Password')"/>

                    <x-input.text id="password_confirmation"
                                  type="password"
                                  name="password_confirmation"
                                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                  required/>
                </div>

                <x-button type="submit" class="btn-primary d-grid w-100 mb-3">
                    {{ __('Reset Password') }}
                </x-button>

                <div class="text-center">
                    <a href="{{ route('login') }}">
                        <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                        Back to login
                    </a>
                </div>
            </form>
        </x-auth-card>
</x-guest-layout>
