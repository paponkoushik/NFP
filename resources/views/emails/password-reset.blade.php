@component('mail::message')
<h2 class="body-title"> Dear <strong> {{ $user['first_name'] }} {{ $user['last_name'] }}</strong>, </h2>
<p>You are receiving this email because we received a password reset request for your account.</p>

<p>Please set a password to finish setting up your Argos account.</p>
@component('mail::button', ['url' => $url])
    Reset Password
@endcomponent

<p>{{ Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]) }}</p>
<p>If you did not request a password reset, no further action is required.</p>
<br>
@lang('Sincerely'),<br><br>
    ShareBridge Team
@endcomponent
