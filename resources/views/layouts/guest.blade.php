<!DOCTYPE html>
@php
    $configData = applClasses();
    $customizerHidden = 'customizer-hide';
@endphp

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ $configData['style'] }}-style {{ $navbarFixed ?? '' }} {{ $menuFixed ?? '' }} {{ $menuCollapsed ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}"
    dir="{{ $configData['textDirection'] }}"
    data-theme="{{ $configData['theme'] }}"
    data-assets-path="{{ asset('/assets') . '/' }}"
    data-base-url="{{url('/')}}"
    data-framework="laravel"
    data-template="{{ $configData['layout'] . '-menu-' . $configData['theme'] . '-' . $configData['style'] }}"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NFP') }} - {{ $title ?? '' }}</title>

        @include('layouts._partials.styles')

        <!-- Page -->
        <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}" />

        <script defer src="{{ asset(mix('/assets/js/app.web.js')) }}"></script>
    </head>
    <body>
        <!-- Content -->
        <div id="app" v-cloak>
            {{ $slot }}
        </div>
        <!-- / Content -->

        @include('layouts._partials.scripts')

    @stack('scripts')
    </body>
</html>
