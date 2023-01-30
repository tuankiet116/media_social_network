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

    protected $casts = [
        'last_time_message' => 'date:Y-m-dTH:i:s'
    ];

    protected $appends = ['lastMessage'];
    
    public function userReceive() {
        return $this->hasOne(User::class, 'id', 'user_receive_id');
    }

    public function getLastMessageAttribute() {
        $userId = $this->user_id;
        $receiver = $this->user_receive_id;
        return Message::where([
            'sender' => $userId,
            'receiver' => $receiver
        ])->orWhere(function ($q) use($receiver, $userId) {
            $q->where([
                'sender' => $receiver,
                'receiver' => $userId
            ]);
        })->orderBy('created_at', 'DESC')->first();
    }
}
