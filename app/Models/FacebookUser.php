<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'access_token',
        'user_id',
        'fb_user_id',
        'data_access_expiration_time',
        'expires_in',
        'created_at',
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
