<x-guest-layout>
    <x-slot:title>Login</x-slot>

    <x-auth-card layout="cover">
        <x-slot name="coverImg" class="bg-no-repeat bg-center bg-cover" style="background-image: url('{{ asset('assets/img/login.jpg') }}')">
            {{-- <img src="{{ asset('assets/img/login.jpg') }}"
                class="img-fluid"
                alt="Login image"
                width="700"
                data-app-dark-img="login.jpg"
                data-app-light-img="login.jpg"> --}}
        </x-slot>

        <h4 class="mb-2">Welcome to {{ config('app.name') }}! 👋</h4>
        <p class="mb-4">Please sign-in to your account and start the adventure</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form class="mb-3" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <x-input.group class="mb-3" for="email" :label="__('Email')">
                <x-input.text id="email" :value="__('Email')" type="email" name="email" :value="old('email')"  placeholder="Enter your email or username" required autofocus />
            </x-input.group>

            <!-- Password -->
            <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                    <x-label for="password" :value="__('Password')" />

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="input-group input-group-merge">
                    <x-input.text id="password"
                        type="password"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password"
                        required autocomplete="current-password" />

                    <span class="input-group-text cursor-pointer" id="show-hide-icon">
                        <i class="bx bx-hide"></i>
                    </span>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                    <label class="form-check-label" for="remember-me">
                        {{ __('Remember me') }}
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <x-button type="submit" class="btn-primary d-grid w-100">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{ route('register') }}">
                <span>Create an account</span>
            </a>
        </p>

        {{--<div class="divider my-4">
            <div class="divider-text">or</div>
        </div>

        <div class="d-flex justify-content-center">
            <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                <i class="tf-icons bx bxl-facebook"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                <i class="tf-icons bx bxl-google-plus"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                <i class="tf-icons bx bxl-twitter"></i>
            </a>
        </div>--}}
    </x-auth-card>

        @push('scripts')
            <script type="text/javascript">
                $(document).ready(function () {
                    // Password hide/show
                    $('#show-hide-icon').on('click', function (event) {
                        event.preventDefault();

                        if ($('#password').attr('type') == 'text') {
                            $('#password').attr('type', 'password');
                            $('#show-hide-icon i').addClass('bx-hide');
                            $('#show-hide-icon i').removeClass('bx-show');
                        } else if ($('#password').attr('type') == 'password') {
                            $('#password').attr('type', 'text');
                            $('#show-hide-icon i').removeClass('bx-hide');
                            $('#show-hide-icon i').addClass('bx-show');
                        }
                    });
                });
            </script>
        @endpush
</x-guest-layout>
