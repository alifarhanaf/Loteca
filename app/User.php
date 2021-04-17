<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rounds(){
        return $this->belongsToMany('App\Models\Round');
    }
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }
    public function comissions()
    {
        return $this->hasMany('App\Models\Comission');
    }
    public function points()
    {
        return $this->hasOne('App\Models\Point');
    }
    public function withdraws()
    
    {
        return $this->hasOne('App\Models\WithDraw');
    }
    public function getAccessToken() {

    $existingToken = $this->tokens()->where( 'revoked', false )->first();

    if ( $existingToken ) {

        return $existingToken->name;
    }
    }
}
