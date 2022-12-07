<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\FacebookUser;
use App\Models\UserInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

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

    public function createUser($data, $accountType = null, $step = 0)
    {
        try {
            DB::beginTransaction();
            $token = base64_encode((string) Str::uuid());
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $accountType == FB ? $data['accessToken'] : $data['password'],
                'is_has_page' => NO_PAGE,
                'token' => $token
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
            if ($this->step = LIMIT_REGISTER_QUERY) {
                throw new Exception(__('auth.register.error_register'));
            }
            $this->createUser($data, $accountType, $step += 1);
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
            $fbUser = FacebookUser::with('user')->where(['fb_user_id' => $data['userID']])->first();
            if ($fbUser) $user = $fbUser->user;
            else $user = null;
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


    public function register($data)
    {
        try {
            $user = User::where('email', $data['email'])->first();
            if ($user) throw new Exception(__('auth.register.email_duplicate'));
            $user = $this->createUser($data);
            auth('web')->login($user, true);
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function checkUserAccount()
    {
        $user = auth()->user();
        if ($user->is_active == ACCOUNT_ACTIVE) {
            return $user;
        }
        return null;
    }

    public function settingUpAccount($data) {
        $userId = auth()->id();
        $dataCreate = [
            'user_id' => $userId
        ];

        $dataUniversity = $this->createSchoolData($data, 'university');

        $result = UserInformation::create($data);
    }

    private function createSchoolData ($data, $typeSchool) {
        if ($data[$typeSchool] == null) {
            return "[]";
        }
    }
}
