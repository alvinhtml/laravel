<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mac extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mac', 'ip', 'nicvendor', 'term_id',
    ];
}
