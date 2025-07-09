<x-guest-layout>
    <x-slot:title>Verify Email</x-slot>

    <x-auth-card layout="cover">
        <x-slot name="coverImg">
            <img src="{{ asset('assets/img/illustrations/boy-verify-email-light.png') }}" class="img-fluid" alt="Login image" width="700" data-app-dark-img="illustrations/boy-verify-email-dark.png" data-app-light-img="illustrations/boy-verify-email-light.png">
        </x-slot>

        <h3 class="mb-2">Verify your email ✉️</h3>

        <p class="text-start">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-primary w-100 my-3">
                    {{ __('Log Out') }}
                </button>
            </form>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <p class="text-center">Didn't get the mail?
                    <x-button type="submit">
                        Resend
                    </x-button>
                </p>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
