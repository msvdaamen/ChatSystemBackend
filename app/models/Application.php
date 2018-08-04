<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public function shortcut() {
        return $this->belongsToMany(Shortcut::class);
    }

    public function dashboard() {
        return $this->hasOne(Dashboard::class);
    }
}
