<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    public function friend() {
        return $this->hasOne(User::class, 'id', 'friend_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
