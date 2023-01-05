<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_has_page',
        'token'
    ];

    protected $appends = ['isFollowed'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }


    public function getImageAttribute() {
        if ($this->attributes['image']) {
            return route('cdn.user_avatar', ['fileName' => $this->attributes['image']]);
        }
        return '';
    }

    public function getBannerAttribute() {
        if ($this->attributes['banner']) {
            return route('cdn.user_background', ['fileName' => $this->attributes['banner']]);
        }
        return '';
    }

    public function userSchool() {
        return $this->hasMany(UserSchool::class);
    }

    public function userInformation() {
        return $this->hasOne(UserInformation::class);
    }

    public function groups() {
        return $this->hasMany(Community::class);
    }

    public function getIsFollowedAttribute() {
        $id = $this->id;
        $currentId = auth()->id();
        $isFollow = Follower::where(['user_id' => $id, 'follower_id' => $currentId])->first();
        if ($isFollow || $this->id == auth()->id()) {
            return true;
        }
        return false;
    }

    public function follower() {
        return $this->hasMany(Follower::class, 'user_id');
    }

    public function following() {
        return $this->hasMany(Follower::class, 'follower_id');
    }
}
