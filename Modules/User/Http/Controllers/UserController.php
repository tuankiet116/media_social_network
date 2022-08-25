<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\UserLoginRequest;

class UserController extends Controller
{
    public function login() {
        return view('user::login');
    }
}
