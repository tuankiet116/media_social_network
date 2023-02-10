@component('mail::message')
  <div>
    <h1>{{ __('messages.mail.thank_for') }} {{ env('APP_NAME') }}</h1>
    <p>{{ __('messages.mail.hi') }}, {{ $user->name }}</p>
    <p>{{ __('messages.mail.we_happy') }} <strong>{{ env('APP_NAME') }}</strong></p>
    <p>{{ __('messages.mail.start_explore') }}</p>
    @component('mail::button', ['url' => route('user.get_setting', ['tokenRegister' => $user->token])])
    {{ __('messages.mail.verify') }}
    @endcomponent
  </div>
@endcomponent
