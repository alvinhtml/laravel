<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ou extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'ouid', 'path', 'desc',
    ];
}
