<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoChat extends Model
{
    use HasFactory;

    protected $table = 'video_chat';

    protected $fillable = [
        'caller',
        'receiver',
        'start_time',
        'end_time',
        'uuid',
        'is_answer',
        'is_accepted'
    ];
}
