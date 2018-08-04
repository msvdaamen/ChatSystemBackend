<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Shortcut extends Model
{
    public function application() {
        return $this->hasOne(Application::class);
    }

    public function dashboard() {
        return $this->belongsTo(Dashboard::class);
    }
}
