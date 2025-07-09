<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flickity/3.0.0/flickity.min.css"
              integrity="sha512-fJcFDOQo2+/Ke365m0NMCZt5uGYEWSxth3wg2i0dXu7A1jQfz9T4hdzz6nkzwmJdOdkcS8jmy2lWGaRXl+nFMQ=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="https://unpkg.com/flickity-fullscreen@2/fullscreen.css">
        <link rel="stylesheet" href="https://unpkg.com/flickity-fade@2/flickity-fade.css">
        {{--        <link rel="stylesheet" href="{{ mix('/assets/vendor/css/pages/app-chat.css') }}" />--}}

{{--        @include('posts.post-style')--}}
    @endpush


    <x-slot:title>Posts</x-slot>

        <post-details
            :auth-user-role="@js(auth()->user()->role)"
            :post="{{ json_encode($post) }}"
            :google-api-key="@js(config()->get('app.google_map_api_key'))"
            :can-legal-support="@js($post->additional['canVisibleToSupport'])"
        ></post-details>


        @push('scripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/flickity/3.0.0/flickity.pkgd.min.js"
                    integrity="sha512-achKCfKcYJg0u0J7UDJZbtrffUwtTLQMFSn28bDJ1Xl9DWkl/6VDT3LMfVTo09V51hmnjrrOTbtg4rEgg0QArA=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="https://unpkg.com/flickity-fullscreen@2/fullscreen.js"></script>

            <script src="https://unpkg.com/flickity-fade@2/flickity-fade.js"></script>
    @endpush
</x-app-layout>
