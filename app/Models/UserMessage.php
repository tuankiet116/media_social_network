<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    use HasFactory;

    protected $table = 'user_message';
    protected $fillable = [
        'user_id',
        'user_receive_id',
        'last_time_message'
    ];

    public function userReceive() {
        return $this->hasOne(User::class, 'id', 'user_receive_id');
    }
}
