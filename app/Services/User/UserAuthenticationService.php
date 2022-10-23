<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\FacebookUser;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $accountType == FB ? $data['accessToken'] : $data['password'],
                'is_has_page' => NO_PAGE
            ]);
            if ($accountType == FB && $user) {
                FacebookUser::create([
                    'access_token' => $data['accessToken'],
                    'fb_user_id' => $data['userID'],
                    'expires_in' => $data['expiresIn'],
                    'data_access_expiration_time' => $data['data_access_expiration_time'],
                    'user_id' => $user->id
                ]);
            }
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw new Exception();
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
        try {
            $data = $request->all();
            $user = FacebookUser::with('user')->where(['fb_user_id' => $data['userID']])->first()->user;
            if (!$user) {
                $user = $this->createUser($data, FB);
            }
            auth('web')->login($user, true);
            $plainToken = $user->createToken("API TOKEN");
            return $plainToken;
        } catch (Exception $e) {
            auth()->logout();
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
