<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    // A Hobby belongs to many users. ( Hooby can belongs to many Users )
    public function users() {
        return $this->belongsToMany(User::class);
    }
}
