<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'follower_id'
    ];

    public function follower() {
        return $this->hasOne(User::class, 'id', 'follower_id');
    }

    public function following() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
