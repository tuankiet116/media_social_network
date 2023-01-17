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

    protected $appends = ['result'];

    protected $table = 'history_search';

    public function getResultAttribute()
    {
        if ($this->result_type == SEARCH_TYPE_USER) {
            return User::where('id', $this->result_id)->first();
        }

        if ($this->result_type == SEARCH_TYPE_COMMUNITY) {
            return Community::where('id', $this->result_id)->first();
        }
    }
}
