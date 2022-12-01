@extends('user::layouts.master', ['title' => __('auth.register.register')])
@section('content')
  <div id="fb-root"></div>
  <div class="container_fluid align-items-center row">
    <div class="row justify-content-center main">
      <div class="col-xs-8 col-lg-4">
        <form id="form" class="p-4" action="{{ route('user.post_register') }}" method="POST">
          @csrf
          @error('login_error')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
          <h1>{{ __('auth.register.form_title') }}</h1>
          <h5>{!! __('auth.register.if_have_account', ['link' => route('user.get_login')]) !!}</h5>
          <div class="mb-lg-3">
            <label for="email" class="form-label">{{ __('auth.common.email') }}:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
          </div>
          <div class="mb-lg-3">
            <label for="password" class="form-label">{{ __('auth.common.password') }}:</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <div class="mb-lg-3">
            <label for="remember_me">{{ __('auth.common.remember_me') }}</label>
            <input id="remmeber_me" name="remember_me" type="checkbox" value="1">
          </div>
          <div class="mb-lg-5 mb-md-8 justify-content-center row">
            <button type="submit" class="btn btn-primary col-6 btn-lg">{{ __('auth.login.login') }}</button>
          </div>
          <div class="separator">
            <div class="line"></div>
            <h5>{{ __('auth.login.or_login_with') }}</h5>
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

      function checkUserFBLogin() {
        FB.getLoginStatus(function(response) {
          debugger
          statusChangeCallback(response);
        });
      }
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
