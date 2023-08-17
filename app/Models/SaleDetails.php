<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetails extends Model
{
    use HasFactory;

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale', 'id');
    }

    public function product() 
    {
        return $this->hasOne(Product::class, 'product', 'id');
    }    
}
