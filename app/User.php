<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'verified'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     *
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verification_token'
    ];
    public function sendPasswordResetNotification($token)
    {
//        $this->notify(new ResetPasswordNotification($token, $this));
    }
    /**
     * Hash passwords
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password']  = Hash::make($value);
    }
    /**
     * Save new api token
     *
     * @return bool
     */
    public function setApiToken()
    {
        $this->attributes['api_token'] = str_random(60);
        return $this->save();
    }
    /**
     * Remove api token
     *
     * @return bool
     */
    public function unsetApiToken()
    {
        $this->attributes['api_token'] = null;
        return $this->save();
    }

}
