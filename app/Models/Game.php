<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function rounds()
    {
        return $this->belongsToMany('App\Models\Round');
    }
    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }
}
