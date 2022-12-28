<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'community_id',
        'title',
        'src',
        'thumbnail_src',
        'post_description'
    ];

    protected $appends = ['isLiked'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function reactionUser() {
        return $this->belongsToMany(User::class, PostUser::class, 'post_id', 'user_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function getIsLikedAttribute() {
        $userLogin = auth()->id();
        if ($userLogin) {
            $result = PostUser::where(['post_id' => $this->id, 'user_id' => $userLogin])->first();
            if ($result) {
                return true;
            }
        }
        return false;
    }

    public function community() {
        return $this->belongsTo(Community::class);
    }
}
