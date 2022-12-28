<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityUser extends Model
{
    use HasFactory;

    protected $table = 'community_user';

    public $fillable = [
        'community_id',
        'user_id'
    ];

    public function community() {
        return $this->belongsTo(Community::class);
    }
}
