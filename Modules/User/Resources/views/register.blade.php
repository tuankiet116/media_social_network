<!DOCTYPE html>
<html>

@extends('user::layouts.master', ['title' => __('auth.register.form_title')])
@section('content')

  <body>
    @if (Session::has('registed'))
      <div class="container is-align-items-center mt-2">
        <div class="has-text-centered">
          <a href="{{ route('home') }}" class="align-items-center is-flex" style="color: white">
            <img style="width: 50px" src="/images/default/brand.png">
            <div class="brand-title is-flex is-align-items-center ml-3" 
                  style="font-size: 1rem; color: blueviolet; font-family: monospace;">
              <h5>{{ config('app.name') }}</h5>
            </div>
          </a>
        </div>
        <div class="box content" style="background: cornsilk; margin-top: 10rem">
          <h2>Registered Successfully</h2>
          <p class="is-flex is-align-items-center">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
              <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="10" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
              <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="10" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
            </svg>
            A verify link has been sent to your E-mail. Please open and verify your E-mail address. 
            You could close this window now.
          </p>
        </div>
      </div>
    @else
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
              <h1>{{ __('auth.register.form_title') }}</h1>
            </div>
            <form action="{{ route('user.post_register') }}" method="POST">
              @csrf
              @error('register_error')
                <div class="notification is-danger">
                  <button type="button" class="delete delete_notification"></button>
                  {{ $message }}
                </div>
              @enderror
              <div class="field">
                <label for="email" class="form-label">{{ __('auth.common.email') }}:</label>
                <div class="control has-icons-right">
                  <input class="input" type="email" name="email" value="{{ old('email') }}">
                  <span class="icon is-small is-right">
                    <i class="fa fa-user"></i>
                  </span>
                </div>
                @error('email')
                  <p class="help is-danger">{{ $message }}</p>
                @enderror
              </div>

              <div class="field">
                <label for="name" class="form-label">{{ __('auth.common.name') }}:</label>
                <div class="control has-icons-right">
                  <input class="input" type="text" name="name" value="{{ old('name') }}">
                  <span class="icon is-small is-right">
                    <i class="fa fa-user"></i>
                  </span>
                </div>
                @error('name')
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
                <label for="password" class="form-label">{{ __('auth.common.reenter_password') }}:</label>
                <div class="control has-icons-right">
                  <input class="input" name="password_cf" type="password">
                  <span class="icon is-small is-right">
                    <i class="fa fa-key"></i>
                  </span>
                </div>
                @error('password_cf')
                  <p class="help is-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="has-text-centered">
                <button type="submit"
                  class="button is-vcentered is-primary is-outlined">{{ __('auth.register.register') }}</button>
              </div>
            </form>

            <div class="has-text-centered">
              {!! __('auth.register.if_have_account', ['link' => route('user.get_login')]) !!}
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
    @endif
  </body>
@endsection
@section('js')
  <script>
    $(document).on('click', '.delete_notification', function() {
      $(this).parent('.notification').remove()
    });
  </script>
@endsection
