<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'keyword',
        'result_type',
        'result_id'
    ];

    protected $table = 'history_search';

    public function result() {
        
    }
}
