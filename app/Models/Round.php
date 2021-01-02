<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    public function games()
    {
        return $this->belongsToMany('App\Models\Game');
    }
    
    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }
}
