<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\FacebookUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;

class UserAuthenticationService
{
    public function login($data)
    {
        $credentials = array(
            'email' => $data['email'],
            'password' => $data['password']
        );
        $remember = isset($data['remember_me']) ? true : false;
        $result = auth('web')->attempt($credentials, $remember);
        if ($result) {
            $user = User::where(['email' => $data['email']])->first();
            auth('web')->login($user, $remember);
            $plainToken = $user->createToken("API TOKEN");
            return $plainToken;
        } else {
            return false;
        }
    }

    public function createUser($data, $accountType = null)
    {
        if ($accountType == FB) {

        }
    }

    public function logout()
    {
        $user = auth()->user();
        if ($user) {
            $user->tokens()->delete();
            auth()->logout();
        }
        return true;
    }

    public function facebookLogin($request)
    {
        $data = $request->all();
        $user = FacebookUser::with('user')->where([
            'fb_user_id' => $data['userID']
        ])->get();
        if ($user) {
            dd('No USer');
        } else {
            $this->createUser($data, FB);
        }
    }
}
