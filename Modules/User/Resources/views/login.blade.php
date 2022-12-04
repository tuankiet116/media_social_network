<!DOCTYPE html>
<html>

@extends('user::layouts.master', ['title' => __('auth.login.form_title')])
@section('content')

  <body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
      src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0&appId=520447719756704&autoLogAppEvents=1"
      nonce="Sr2unXDw"></script>
    <div class="columns is-vcentered">
      <div class="login column is-4 ">
        <section class="section">
          <div class="has-text-centered">
            <a href="{{ route('home') }}" class="align-items-center" style="color: white">
              <img style="width: 120px" src="/images/default/brand.png">
              <div class="brand-title" style="font-size: 2rem; color: blueviolet; font-family: monospace;">
                <h3>{{ config('app.name') }}</h3>
              </div>
            </a>
          </div>
          <div class="title-form">
            <h1>{{ __('auth.login.form_title') }}</h1>
          </div>
          <form action="{{ route('user.post_login') }}" method="POST">
            @csrf
            @error('login_error')
              <div class="notification is-danger">
                <button type="button" class="delete-notification"></button>
                {{ $message }}
              </div>
            @enderror
            <div class="field">
              <label for="email" class="form-label">{{ __('auth.common.email') }}:</label>
              <div class="control has-icons-right">
                <input class="input" type="email" name="email">
                <span class="icon is-small is-right">
                  <i class="fa fa-user"></i>
                </span>
              </div>
              @error('email')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label for="password" class="form-label">{{ __('auth.common.password') }}:</label>
              <div class="control has-icons-right">
                <input class="input" name="password" type="password">
                <span class="icon is-small is-right">
                  <i class="fa fa-key"></i>
                </span>
              </div>
              @error('password')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="field">
              <label for="remember_me">{{ __('auth.common.remember_me') }}</label>
              <input id="remmeber_me" name="remember_me" type="checkbox" value="1">
            </div>
            <div class="has-text-centered">
              <button type="submit"
                class="button is-vcentered is-primary is-outlined">{{ __('auth.login.login') }}</button>
            </div>
          </form>

          <div class="has-text-centered">
            {!! __('auth.login.if_dont_have_account', ['link' => route('user.get_register')]) !!}
          </div>
          <hr>
          <div class="has-text-centered">
            <h5>{{ __('auth.login.or_login_with') }}</h5>
          </div>
          <div class="has-text-centered">
            <div class="fb-login-button row p-2" data-width="100" data-size="medium" data-button-type="continue_with"
              data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true"
              data-scope="public_profile,email">
            </div>
          </div>
        </section>
      </div>
      <div id="particles-js" class="interactive-bg column is-8">
      </div>
    </div>
  </body>
@endsection
@section('js')
<script>
  $(document).on('click', '.delete_notification', function() {
    $(this).parent('.notification').remove()
  });
</script>
@endsection
