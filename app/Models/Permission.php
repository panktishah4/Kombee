<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    // Permission belongs to many roles (A Permission Can belong to many roles (many-to-many))
    public function roles() {
        return $this->belongsToMany(Role::class);
    }
    
}
