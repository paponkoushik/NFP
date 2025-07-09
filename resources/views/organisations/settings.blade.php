<x-app-layout>
    <div class="row mt-2">
        <x-slot:title>Organisation Settings</x-slot>

            <organisation-settings
                :organisation="@js($organisation)"
                :service-areas="@js($serviceAreas)"
                :interests="@js($interests)"
                :auth-user="@js(auth()->user())"
            ></organisation-settings>
    </div>
</x-app-layout>
