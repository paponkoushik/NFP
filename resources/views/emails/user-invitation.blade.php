{{--@component('mail::message')--}}
{{--@php --}}
{{--    $organisation = optional($user->organisationUser)->organisation;--}}
{{--@endphp--}}
{{--<h2 class="body-title"> Dear <strong> {{ $user['first_name'] }} {{ $user['last_name'] }}</strong>, </h2>--}}
{{--@if($organisation && $organisation->org_type == 'client')--}}
{{--@if( $organisation->is_trial == 1)--}}
{{--<p>Your 14-day trial account for <strong> {{ $organisation->org_name }} </strong> in Argos is almost ready!</p>--}}
{{--@else--}}
{{--<p>You have been invited to join the company <strong> {{ $organisation->org_name }} </strong> in Argos.</p>--}}
{{--@endif--}}
{{--@elseif($organisation && $organisation->org_type == 'publisher')--}}
{{--<p>You have been invited to join the publisher <strong> {{ $organisation->org_name }} </strong> in Argos.</p>--}}
{{--@else--}}
{{--<p>You have been invited to join in Argos.</p>--}}
{{--@endif--}}

{{--<p>Please set a password to finish setting up your Argos account.</p>--}}
{{--@component('mail::button', ['url' => $url])--}}
{{--    CREATE PASSWORD--}}
{{--@endcomponent--}}

{{--<p> If you didn’t request an account or believe you may have been invited by mistake, please ignore this email or contact support@argos-reg.tech.</p>--}}
{{--<br>--}}
{{--@if (! empty($salutation))--}}
{{--    {{ $salutation }}--}}
{{--@else--}}
{{--@lang('Sincerely'),<br><br>--}}
{{--    Argos Support Team--}}
{{--@endif--}}
{{--@endcomponent--}}

<x-mail::message>
    # Login Credentials Account

    Your account has been created as an Organization Admin.
    Please login using these credentials.

    Login Email : {{ $user['email'] }}
    Login password : p@ssword

    Thanks,
    {{ config('app.name') }}
</x-mail::message>
