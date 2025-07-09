<!DOCTYPE html>
@php
    $configData = applClasses();
@endphp

<html lang="{{ session()->get('locale') ?? app()->getLocale() }}"
    class="{{ $configData['style'] }}-style {{ $navbarFixed ?? '' }} {{ $menuFixed ?? '' }} {{ $menuCollapsed ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}"
    dir="{{ $configData['textDirection'] }}"
    data-theme="{{ $configData['theme'] }}"
    data-assets-path="{{ asset('/assets') . '/' }}"
    data-base-url="{{url('/')}}"
    data-framework="laravel"
    data-template="{{ $configData['layout'] . '-menu-' . $configData['theme'] . '-' . $configData['style'] }}"
>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} - {{ $title ?? '' }}</title>

        <meta name="description" content="" />
        <meta name="keywords" content="management">

        @include('layouts._partials.styles')

        <link rel="stylesheet" href="{{ asset(mix('/assets/css/app.css')) }}" />
    </head>

    <body>
        <div id="fullpage-spinner">
            <button class="btn btn-lg rounded-0 bg-label-instagram" type="button" disabled>
                <span class="spinner-border" role="status" aria-hidden="true"></span>
                <span class="ms-2">Please wait...</span>
            </button>
        </div>

        @include('layouts.' . $configData['mainLayoutType'])

        {{-- <div class="buy-now">
            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#myPreferencesOffcanvas" aria-controls="myPreferencesOffcanvas" data-bs-toggle="tooltip" data-bs-offset="0,4" title="My Prefarences" class="btn btn-label-danger btn-sm btn-buy-now px-1 py-0">
                <i class="bx bx-menu-alt-right fs-3"></i>
            </a>
        </div> --}}

        @include('company.my-preferences-modal')

        @include('layouts._partials.scripts')

        <script src="{{ asset(mix('assets/vendor/libs/flatpickr/flatpickr.js')) }}"></script>

        <script defer src="{{ asset(mix('/assets/js/app.js')) }}"></script>

        <!-- BEGIN: Theme JS-->
        <script defer src="{{ asset(mix('assets/js/main.js')) }}"></script>


        @stack('scripts')
    </body>
</html>
