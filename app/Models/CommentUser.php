<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentUser extends Model
{
    use HasFactory;

    protected $table = "comment_user";
    protected $fillable = [
        'user_id',
        'comment_id'
    ];
}
