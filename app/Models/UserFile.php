<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    protected $fillable = [
        'user_id','file_path'
    ];

    // A Userfile belongs to User( Userfile can belongs to Users) 
    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
