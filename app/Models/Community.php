<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_name',
        'user_id',
        'image',
        'background'
    ];

    public function getImageAttribute() {
        if ($this->attributes['image']) {
            return route('cdn.community_avatar', ['fileName' => $this->attributes['image']]);
        }
        return '';
    }

    public function getBackgroundAttribute() {
        if ($this->attributes['background']) {
            return route('cdn.community_background', ['fileName' => $this->attributes['background']]);
        }
        return '';
    }
}
