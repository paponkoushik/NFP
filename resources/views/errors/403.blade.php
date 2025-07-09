<x-guest-layout>
    <x-slot:title>403 | Forbidden</x-slot>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}" />
    @endpush

    <!-- Error -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2">403 :(</h2>
            <p class="mb-4 mx-2">{{ $exception->getMessage() ?: 'Access denied!' }}</p>
            <a href="/" class="btn btn-primary">Back to home</a>
            <div class="mt-3">
                <img
                    src="{{ asset('/assets/img/illustrations/page-misc-error-light.png') }}"
                    alt="{{ config('app.name') }}"
                    width="500"
                    class="img-fluid"
                    data-app-dark-img="illustrations/page-misc-error-dark.png"
                    data-app-light-img="illustrations/page-misc-error-light.png"
                />
            </div>
        </div>
    </div>
    <!-- /Error -->
</x-guest-layout>
