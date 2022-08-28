@extends('user::layouts.master', ['title' => __("user::auth.login.form_title")])
@section('content')
    
<div class="container">
    <div class="image">
        <h1>Welcome To <span>CodeFun</span></h1>
    </div>
    <div class="content">
        <h1>Login</h1>
        <div class="form-group">
            <label for="">Email</label>
            <br>
            <input type="text" class="form-control input-custom" name="" id="email" aria-describedby="helpId" placeholder="Email">

        </div>
        <div class="form-group">
            <label for="">Password</label>
            <br>
            <input type="password" class="form-control input-custom" name="" id="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label>Or Login With</label>
            <div class="row">
                
            </div>
        </div>
        <br>
        <a class="fp" href="index.html">Forgot Password?</a>
        <br>
        <button type="button" class="btn"><a href="index.html">Login</a></button>
    </div>
</div>
@endsection