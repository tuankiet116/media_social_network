<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSchool extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'school_name',
        'start_year',
        'end_year',
        'school_type'
    ];
}
