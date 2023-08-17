<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{    
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];    

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($password)    
    {
        $this->attributes['password'] = sha1($password);
    }

    public function details()
    {
        return $this->hasOne(UserDetail::class, 'user', 'id');
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'user', 'id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'user', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($user) {            
            if(!$details = $user->details) return;
            if(Storage::exists($details->profile)) {
                Storage::delete($details->profile);
            }        
        });
    }
}
