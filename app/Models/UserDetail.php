<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile',
        'cpf',            
        'first_name',
        'last_name',            
        'phone_number'
    ];

    public function getProfileUrl()
    {
        $this->setAttribute('profile', url('storage/'.$this->attributes['profile']));
    }

    public function email() 
    {
        $this->setAttribute('email', User::find($this->id)->pluck('email'));
    }
}
