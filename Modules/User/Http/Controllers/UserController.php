<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\UserAuthenticationService;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\UserLoginRequest;

class UserController extends Controller
{
    use ApiResponse;
    private $UserAuthService;

    public function __construct(UserAuthenticationService $UserAuthService)
    {
        $this->UserAuthService = $UserAuthService;
    }

    public function login()
    {
        return view('user::login');
    }

    public function attempLogin(UserLoginRequest $request)
    {
        $token = $this->UserAuthService->login($request->validated());
        if ($token === false) {
            // dd(app()->getLocale());
            return redirect()->back()->withErrors(['login_error' => __('auth.login.error_login')]);
        }
        return redirect()->route('home');
    }

    public function showFormRegister() {

    }

    public function register()
    {
    }

    public function forgotPassword()
    {
    }

    public function getUserInformation()
    {
        $data = auth()->user();
        return $this->responseSuccess($data);
    }

    public function logout() {
        $this->UserAuthService->logout();
        return $this->responseSuccess([true]);
    }
}
