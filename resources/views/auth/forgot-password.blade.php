<x-guest-layout>
    <x-slot:title>Forgot Password</x-slot>

        <x-auth-card layout="cover">
            <x-slot name="coverImg">
                <img src="{{ asset('assets/img/illustrations/girl-unlock-password-light.png') }}" class="img-fluid"
                     alt="Login image" width="700" data-app-dark-img="illustrations/girl-unlock-password-dark.png"
                     data-app-light-img="illustrations/girl-unlock-password-light.png">
            </x-slot>

            <h4 class="mb-2">Forgot Password? 🔒</h4>
            <p class="mb-4">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors"/>

            <form method="POST" class="mb-3" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <x-label for="email" :value="__('Email')"/>

                    <x-input.text id="email" type="email" name="email" :value="old('email')"
                                  placeholder="Enter your email" required autofocus/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button type="submit" class="btn-primary d-grid w-100">
                        {{ __('Email Password Reset Link') }}
                    </x-button>
                </div>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                    <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                    Back to login
                </a>
            </div>
        </x-auth-card>
</x-guest-layout>
