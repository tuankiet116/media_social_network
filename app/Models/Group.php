<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'user_id',
        'image',
        'banner'
    ];

    public function getImageAttribute() {
        if ($this->attributes['image']) {
            return route('cdn.community_avatar', ['fileName' => $this->attributes['image']]);
        }
        return '';
    }

    public function getBannerAttribute() {
        if ($this->attributes['banner']) {
            return route('cdn.community_background', ['fileName' => $this->attributes['banner']]);
        }
        return '';
    }
}
