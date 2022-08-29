@extends('user::layouts.master', ['title' => __("user::auth.login.form_title")])
@section('content')
    
<div class="container">
    <div class="image">
        <h1>Welcome To <span>Movies Sharing</span></h1>
    </div>
    <div class="content">
        <h1>Login</h1>
        <form class="form-inline" method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control input-custom" name="email" id="email" aria-describedby="helpId" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control input-custom" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label>Or Login With</label>
                <div class="row">
    
                </div>
            </div>
            <a class="fp" href="index.html">Forgot Password?</a>
            <button type="button" class="btn"><a href="index.html">Login</a></button>
        </form>
    </div>
</div>
@endsection