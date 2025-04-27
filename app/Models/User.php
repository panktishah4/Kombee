<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens,HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'contact_number',
        'postcode',
        'gender_id',
        'state_id',
        'city_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // User belongs to many roles (A user can have multiple roles)
    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    // User belongs to many hobbies ( A user can have multiple hobbies (many-to-many))
    public function hobbies(){
        return $this->belongsToMany(Hobby::class);
    }

    //User belongs to Gender (one-to-many inverse)
    public function gender(){
        return $this->belongsTo(Gender::class);
    }
    
    //User has many files (has-many)
    public function files() {
        return $this->hasMany(UserFile::class);
    }

    public function state() {
        return $this->belongsTo(State::class);
    }
    
    public function city() {
        return $this->belongsTo(City::class);
    }

    
}
