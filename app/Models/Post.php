<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'title',
        'src',
        'thumbnail_src',
        'post_description'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
