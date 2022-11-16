<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'belong_id',
        'content',
        'created_at',
        'updated_at'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes() {
        return $this->belongsToMany(User::class);
    }
}
