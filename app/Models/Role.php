<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Role belongs to many permissions ( A role can have many permissions (many-to-many) 
    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    // Role belongs to many users ( A role can belong to many users (many-to-many))
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
