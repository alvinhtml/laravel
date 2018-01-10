<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'ou_id', 'hostname', 'os', 'user_id', 'state', 'desp',
    ];

    public function macs()
    {
        return $this->hasMany('App\Mac');
    }
    public function ou()
    {
        return $this->belongsTo('App\Ou');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
