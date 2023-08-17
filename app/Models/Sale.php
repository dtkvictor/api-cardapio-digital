<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function payment()
    {
        return $this->hasOne(PaymentMethod::class, 'payment', 'id');
    }

    public function details()
    {
        return $this->hasMany(SaleDetails::class, 'sale', 'id');
    }
}
