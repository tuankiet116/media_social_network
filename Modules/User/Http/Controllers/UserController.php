<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\UserAuthenticationService;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\UserLoginRequest;
use Modules\User\Http\Requests\UserRegisterRequest;
use Exception;
use Illuminate\Http\Request;
use Modules\User\Http\Requests\User\RegisterSettingRequest;
use Modules\User\Http\Requests\UserUpdatePasswordRequest;

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
            return redirect()->back()->withErrors(['login_error' => __('auth.login.error_login')]);
        }
        return redirect()->route('home');
    }

    public function showFormRegister()
    {
        return view('user::register');
    }

    public function register(UserRegisterRequest $request)
    {
        $data = $request->validated();
        try {
            $result = $this->UserAuthService->register($data);
            if ($result) {
                return redirect()->back()->with('registed', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['register_error' => $e->getMessage()])->withInput();
        }
    }

    public function forgotPassword()
    {
    }

    public function getUserInformation()
    {
        $user = $this->UserAuthService->checkUserAccount();
        if ($user) {
            return $this->responseData($user, 200);
        }
        return $this->responseData(null, 403);
    }

    public function logout()
    {
        $this->UserAuthService->logout();
        return $this->responseData([true], 200);
    }

    public function showSettingRegister($tokenRegister = null) {
        try {
            if ($tokenRegister == null) throw new Exception('NO TOKEN');
            $files = $this->UserAuthService->getSettingRegister($tokenRegister);
            $avatarImages = array(
                'title' => 'Avatars',
                'files' => $files
            );
            return view('user::accountSetting')->with(['avatarImages' => $avatarImages]);
        } catch(Exception $e) {
            abort(404);
        }
    }

    public function settingRegister(RegisterSettingRequest $request) {
        try {
            $data = $request->validated();
            $files = $request->allFiles();
            $this->UserAuthService->settingUpRegister($data, $files);
            return redirect()->route('home');
        } catch(Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function updatePassword(UserUpdatePasswordRequest $request) {
        $result = $this->UserAuthService->updatePassword($request->validated());
        if ($result == false) {
            return $this->responseData(array('errors' => ['old_password' => __('auth.update_password.old_password_invalid')]), 422);
        }
        return $this->responseData('Password Updated');
    }
}
