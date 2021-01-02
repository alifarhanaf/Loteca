<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function rounds()
    {
        return $this->belongsToMany('App\Models\Round');
    }
}
