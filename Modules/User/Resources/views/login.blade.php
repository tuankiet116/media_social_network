@extends('user::layouts.master', ['title' => __('user::auth.login.form_title')])
@section('content')
  <div id="fb-root"></div>
  <div class="container_fluid align-items-center row">
    <div class="row justify-content-center">
      <div class="col-3">
        <form id="form" class="p-4" action="{{ route('user.post_login') }}" method="POST">
          @csrf
          @error('login_error')
            <small>{{ $message }}</small>
          @enderror
          <h1>{{ __('auth.login.form_title') }}</h1>
          <div class="mb-3">
            <label for="email" class="form-label">{{__('auth.common.email')}}:</label>
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
        </form>
      </div>
    </div>
  </div>
@endsection

@push('js')
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{your-app-id}',
      cookie     : true,
      xfbml      : true,
      version    : '{api-version}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>  
@endpush
