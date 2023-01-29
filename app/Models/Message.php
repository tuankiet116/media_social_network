<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'message';
    protected $fillable = [
        'sender',
        'receiver',
        'message',
    ];

    public function receiverUser()
    {
        return $this->hasOne(User::class, 'id', 'receiver');
    }

    public function senderUser() {
        return $this->hasOne(User::class, 'id', 'sender');
    }
}
