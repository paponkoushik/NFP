<x-guest-layout>
    <x-slot:title>Confirm Password</x-slot>

    <x-auth-card>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" class="mb-3" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Password')" />

                <x-input.text id="password"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
            </div>

            <div class="flex justify-end mt-4">
                <x-button type="submit" class="btn-primary d-grid w-100">
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
