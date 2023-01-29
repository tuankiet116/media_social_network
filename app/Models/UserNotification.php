<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_sender_id',
        'community_sender_id',
        'type',
        'read',
        'post_id',
        'comment_id',
        'community_id'
    ];

    public function userSender()
    {
        return $this->belongsTo(User::class, 'user_sender_id');
    }

    public function communitySender()
    {
        return $this->belongsTo(Community::class, 'community_sender_id');
    }
}
