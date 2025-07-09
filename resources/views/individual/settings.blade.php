<x-app-layout>
    <div class="row mt-2">
        <x-slot:title>Individual Settings</x-slot>

{{--        <individual-settings--}}
{{--            :organisation="@js($organisation)"--}}
{{--            :service-areas="@js($serviceAreas)"--}}
{{--            :interests="@js($interests)"--}}
{{--            :preferences="@js(preferencesList())"--}}
{{--            :demo-interests="@js(demoInterests())"--}}
{{--        ></individual-settings>--}}

            <organisation-settings
                :organisation="@js($organisation)"
                :service-areas="@js($serviceAreas)"
                :interests="@js($interests)"
                :auth-user="@js(auth()->user())"
            ></organisation-settings>
    </div>
</x-app-layout>
