<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\FacebookUser;
use App\Models\UserInformation;
use App\Models\UserSchool;
use App\Services\Inf\StorageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Mail;
use Modules\User\Emails\EmailRegister;

class UserAuthenticationService
{
    private $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    public function login($data)
    {
        $credentials = array(
            'email' => $data['email'],
            'password' => $data['password'],
            'is_active' => ACCOUNT_ACTIVE
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
            Mail::to($user->email)->queue(new EmailRegister($user));
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

    public function getSettingRegister($tokenRegister)
    {
        $user = User::where([
            'token' => $tokenRegister,
            'is_active' => ACCOUNT_UNACTIVE
        ])->first();
        if ($user) {
            auth()->login($user);
            $files = collect(Storage::allFiles('public/defaults/avatars'))->map(function ($file) {
                return Storage::url($file);
            });
            return $files;
        } else {
            throw new Exception('NO USER FOUND');
        }
    }

    public function settingUpRegister($data, $files)
    {
        $userId = auth()->id();
        try {
            DB::beginTransaction();
            UserInformation::create([
                'user_id' => $userId,
                'living_place' => $data['living_place'],
                'working_place' => $data['working_place'],
                'gender' => $data['gender']
            ]);

            if ($data['highschool_name']) {
                UserSchool::create([
                    'school_name' => $data['highschool_name'],
                    'start_year' => $data['highschool_start'],
                    'end_year' => $data['highschool_gradueted'],
                    'school_type' => SCHOOLE_HIGHSCHOOL,
                    'user_id' => $userId
                ]);
            }

            if ($data['university_name']) {
                UserSchool::create([
                    'school_name' => $data['university_name'],
                    'start_year' => $data['university_start'],
                    'end_year' => $data['university_gradueted'],
                    'schoole_type' => SCHOOLE_UNIVERSITY,
                    'user_id' => $userId
                ]);
            }
            $user = User::where('id', $userId)->first();

            if ($data['avatar_image_choose']) {
                $fileName = $this->storageService->copyImagePublicStorage('/user/avatar/', $data['avatar_image_choose']);
                $user->image = $fileName;
            } else if (isset($files['avatar_image'])) {
                $avatarImage = $files['avatar_image'];
                $fileName = $this->storageService->saveToLocalStorage('/user/background/', $avatarImage, false);
                $user->image = $fileName;
            }

            if (isset($files['banner_image'])) {
                $fileName = $this->storageService->saveToLocalStorage('/user/background/', $files['banner_image'], false);
                $user->banner = $fileName;
            } else {
                $fileName = $userId . time() . '.png';
                Storage::copy('/public/defaults/background/background.png', '/user/background/' . $fileName);
                $user->banner = $fileName;
            }

            $user->is_active = ACCOUNT_ACTIVE;
            $user->token = null;
            $user->save();
            DB::commit();
        } catch (Exception $e) {
            dd($e);
            throw new Exception($e);
        }
    }
}
