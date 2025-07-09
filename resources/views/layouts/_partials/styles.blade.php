<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="./img/favicon/favicon.ico" />

<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preload" href="{{ asset(mix('/assets/css/fonts.css')) }}" as="style" onload="this.rel='stylesheet'" />

<!-- Icons -->
<link rel="stylesheet" href="{{ asset(mix('/assets/vendor/fonts/boxicons.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('/assets/vendor/fonts/fontawesome.css')) }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset(mix('/assets/vendor/css/rtl/core.css')) }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset(mix('/assets/vendor/css/rtl/theme-default.css')) }}" class="template-customizer-theme-css" />

@stack('vendor-styles')

<!-- Config -->
<script src="{{ asset(mix('/assets/vendor/js/helpers.js')) }}"></script>

@if(!$configData['blankPage'])
    <script src="{{ asset(mix('/assets/js/config.js')) }}"></script>
@endif

<!-- beautify ignore:start -->
{{--@if ($configData['hasCustomizer'])
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    @php
        $resolvedPaths = [];
        // Core stylesheets
        foreach (['core'] as $name) {
            $resolvedPaths["{$name}.css"] = asset(mix("assets/vendor/css{$configData['rtlSupport']}/{$name}.css"));
            $resolvedPaths["{$name}-dark.css"] = asset(mix("assets/vendor/css{$configData['rtlSupport']}/{$name}-dark.css"));
        }

        // Themes
        foreach (['default', 'bordered', 'semi-dark'] as $name) {
            $resolvedPaths["theme-{$name}.css"] = asset(mix("assets/vendor/css{$configData['rtlSupport']}/theme-{$name}.css"));
            $resolvedPaths["theme-{$name}-dark.css"] = asset(mix("assets/vendor/css{$configData['rtlSupport']}/theme-{$name}-dark.css"));
        }
    @endphp
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <script>
        window.templateCustomizer = new TemplateCustomizer({
            cssPath: '',
            themesPath: '',
            defaultShowDropdownOnHover: @js($configData['showDropdownOnHover']), // true/false (for horizontal layout only)
            displayCustomizer: @js($configData['displayCustomizer']),
            lang: '{{ app()->getLocale() }}',
            pathResolver: function(path) {
                var resolvedPaths = @js($resolvedPaths);
                return resolvedPaths[path] || path;
            },
            'controls': @js($configData['customizerControls']),
        });
    </script>
@endif--}}
<!-- beautify ignore:end -->

<link rel="stylesheet" href="{{ mix('/assets/css/style.css') }}" />

@stack('styles')

