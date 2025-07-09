<x-guest-layout>
    <x-slot:title>503 | Server Maintenance</x-slot>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}" />
    @endpush

    <!-- Error -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2">Under Maintenance!</h2>
            <p class="mb-4 mx-2">Sorry for the inconvenience but we're performing some maintenance at the moment</p>
            <a href="/" class="btn btn-primary">Back to home</a>
            <div class="mt-3">
                <img
                    src="{{ asset('/assets/img/illustrations/girl-doing-yoga-light.png') }}"
                    alt="{{ config('app.name') }}"
                    width="500"
                    class="img-fluid"
                    data-app-dark-img="illustrations/girl-doing-yoga-dark.png"
                    data-app-light-img="illustrations/girl-doing-yoga-light.png"
                />
            </div>
        </div>
    </div>
    <!-- /Error -->
</x-guest-layout>
