<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="NFP, ShareBridge" />
        <meta name="keywords" content="NFP, ShareBridge" />
        <meta name="author" content="elemis" />
        <title>{{ config('app.name') }} - {{ $title ?? '' }}</title>

        <link rel="icon" type="image/x-icon" href="/img/favicon/favicon.ico" />
        <!-- Fonts -->
        <link rel="preload" href="{{ asset(mix('/assets/css/fonts.css')) }}" as="style" onload="this.rel='stylesheet'" />
                
        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset(mix('/assets/vendor/fonts/boxicons.css')) }}" />
        <link rel="stylesheet" href="{{ asset(mix('/assets/vendor/fonts/fontawesome.css')) }}" />

        <link rel="stylesheet" href="{{ asset('/assets/frontend/css/plugins.css') }}" />
        <link rel="stylesheet" href="{{ asset('/assets/frontend/css/style.css') }}" />

        @stack('styles')

        <script defer src="{{ asset('/assets/frontend/js/plugins.js') }}"></script>
        <script defer src="{{ asset('/assets/frontend/js/theme.js') }}"></script>
        <script defer src="{{ asset(mix('/assets/js/app.js')) }}"></script>
    </head>

    <body>
        <div class="content-wrapper" id="app" v-clock>
            @include('frontend.layouts.header')

            <flash message="{{ session('flash_message') }}"
                level="{{ session('flash_message_level') }}"
                important="{{ session('flash_important') }}"
            ></flash>

            {{ $slot }}
        </div>
        <!-- /.content-wrapper -->

        @include('frontend.layouts.footer')

        @stack('scripts')
    </body>
</html>
