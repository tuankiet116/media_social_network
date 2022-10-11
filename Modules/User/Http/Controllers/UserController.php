<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\UserAuthenticationService;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
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
        App::setlocale(request()->getPreferredLanguage());
        return view('user::login');
    }

    public function attempLogin(UserLoginRequest $request)
    {
        $token = $this->UserAuthService->login($request->validated());
        if ($token === false) {
            return redirect()->back()->withErrors(['login_error' => __('auth.login.error_login')]);
        }
        return redirect()->route('home')->with('plainTextToken', 'aaaa');
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
        
    }
}
