@extends('user::layouts.master', ['title' => __('user::auth.login.form_title')])
@section('content')
  <div id="fb-root"></div>
  <div class="container_fluid align-items-center row">
    <div class="row justify-content-center">
      <div class="col-xs-8 col-lg-4">
        <form id="form" class="p-4" action="{{ route('user.post_login') }}" method="POST">
          @csrf
          {{ dd(app()->getLocale()); }}
          @error('login_error')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
          <h1>{{ __('auth.login.form_title') }}</h1>
          <h4>{!! __('auth.login.if_dont_have_account', ['link' => route('user.get_register')]) !!}</h4>
          <div class="mb-3">
            <label for="email" class="form-label">{{ __('auth.common.email') }}:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">{{ __('auth.common.password') }}:</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <div class="mb-3">
            <label for="remember_me">{{ __('auth.common.remember_me') }}</label>
            <input id="remmeber_me" name="remember_me" type="checkbox" value="1">
          </div>
          <div class="mb-5 justify-content-center row">
            <button type="submit" class="btn btn-primary col-6 btn-lg">{{ __('auth.login.login') }}</button>
          </div>
          <div class="separator">
            <div class="line"></div>
            <h4>{{ __('auth.login.or_login_with') }}</h4>
            <div class="line"></div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId: '{your-app-id}',
        cookie: true,
        xfbml: true,
        version: '{api-version}'
      });

      FB.AppEvents.logPageView();

    };

    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
        return;
      }
      js = d.createElement(s);
      js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
@endsection

@section('css')
  <style>
    .row {
      margin: 0;
    }

    .separator {
      display: flex;
      align-items: center;
    }

    .separator .line {
      height: 3px;
      flex: 1;
      background-color: #000;
    }

    .separator h4 {
      padding: 0 2rem;
    }
  </style>
@endsection()
