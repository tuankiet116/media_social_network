@extends('user::layouts.master', ['title' => __('auth.login.form_title')])
@section('content')
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous"
    src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0&appId=520447719756704&autoLogAppEvents=1"
    nonce="Sr2unXDw"></script>
  <div class="row brand align-items-center" style="z-index: 1000; color: white">
    <img src="/images/default/brand.png">
    <div class="brand-title" style="width: 100px">
      <h3>{{ config('app.name') }}</h3>
    </div>
  </div>
  <div class="container_fluid align-items-center row">
    <div class="row justify-content-center main">
      <div class="col-xs-8 col-lg-4">
        <form id="form" class="p-4" action="{{ route('user.post_login') }}" method="POST">
          @csrf
          @error('login_error')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
          <h1>{{ __('auth.login.form_title') }}</h1>
          <h5>{!! __('auth.login.if_dont_have_account', ['link' => route('user.get_register')]) !!} <i class="fa-solid fa-arrow-right-long"></i></h5>
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
            <button type="submit" class="btn btn-primary col-lg-6 btn-lg">{{ __('auth.login.login') }}</button>
          </div>
          <div class="separator">
            <div class="line"></div>
            <h5>{{ __('auth.login.or_login_with') }}</h5>
            <div class="line"></div>
          </div>
          <div class="row align-content-center">
            <div class="col-12" id="fb-login-button">
              <div class="fb-login-button row p-2" data-width="" data-size="large" data-button-type="continue_with"
                data-layout="rounded" data-onlogin="checkUserFBLogin()" data-auto-logout-link="false"
                data-use-continue-as="false">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      window.fbAsyncInit = function() {
        FB.init({
          appId: '520447719756704',
          xfbml: true,
          version: 'v15.0'
        });
        FB.AppEvents.logPageView();
        checkUserFBLogin();
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

      (function(d) {
        var js, id = 'facebook-jssdk';
        if (d.getElementById(id)) {
          return;
        }
        js = d.createElement('script');
        js.id = id;
        js.async = true;
        js.src = "https://connect.facebook.net/es_LA/all.js";
        d.getElementsByTagName('head')[0].appendChild(js);
      }(document));
    });

    function checkUserFBLogin() {
      FB.getLoginStatus(function(response) {
        debugger
      });
    }
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
      background-color: #0067ff;
      margin-left: 10px;
      margin-right: 10px;
    }

    .separator h4 {
      padding: 2px 2rem;
    }

    .fb-login-button {
      text-align: center;
    }
  </style>
@endsection()
