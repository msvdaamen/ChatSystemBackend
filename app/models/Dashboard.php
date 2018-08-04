<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    public function application() {
        return $this->belongsTo(Application::class);
    }

    public function shortcut() {
        return $this->hasOne(Shortcut::class);
    }
}
