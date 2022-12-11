@component('mail::message')
  <div>
    <h1>Thank you for using {{ env('APP_NAME') }}</h1>
    <p>Hi, {{ $user->name }}</p>
    <p>We're happy you signed up for <strong>{{ env('APP_NAME') }}</strong></p>
    <p>To start exploring and join us, please confirm your email address.</p>
    @component('mail::button', ['url' => route('user.get_setting', ['tokenRegister' => $user->token])])
    Verify Now
    @endcomponent
  </div>
@endcomponent
