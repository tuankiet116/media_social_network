@extends('user::layouts.master', ['title' => __('user::auth.login.form_title')])
@section('content')
  <div id="fb-root"></div>
  <div class="container">
    <div class="image">
      <h1>Welcome To <span>Movies Sharing</span></h1>
    </div>
    <div class="content">
      <h1>Login</h1>
      <form class="row" method="POST" action="{{ route('user.get_login') }}">
        <div class="row">
          <label class="col-3" for="email">Email</label>
          <input type="text" class="input-custom col-9" name="email" id="email" aria-describedby="helpId"
            placeholder="Email">
        </div>
        <div class="row">
          <label class="col-3" for="password">Password</label>
          <input type="password" class="input-custom col-9" name="password" id="password" placeholder="Password">
        </div>
        <div class="row">
          <label align="center">Or Login With</label>
          <div class="row" align="center">
            <div class="fb-login-button" data-width="" data-size="large" data-button-type="continue_with"
              data-layout="default" data-auto-logout-link="false" data-use-continue-as="true"></div>
          </div>
        </div>
        <a class="fp" href="index.html">Forgot Password?</a>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
  <style>
    .row {
      margin-left: 0;
      margin-right: 0;
      padding: 5px
    }

    .form-control {
      width: auto !important;
    }
  </style>
@endsection
