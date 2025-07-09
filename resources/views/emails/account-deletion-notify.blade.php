@component('mail::message')
<h2 class="body-title"> Dear <strong> {{ $user['first_name'] }} {{ $user['last_name'] }}</strong>, </h2>
<p>
    Your Argos account has successfully been deleted. 
</p>

<p>
    If you believe your account may have been deleted without your permission, please contact info@argos-reg.tech for help.
</p>
<br>

@if (! empty($salutation))
    {{ $salutation }}
@else
@lang('Sincerely'),<br><br>
    Argos Support Team
@endif
@endcomponent
