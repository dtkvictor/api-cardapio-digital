<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'slug',
        'thumb',
        'price',
        'description',        
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }     

    public function getThumbUrl()
    {
        if(!preg_match('/^https?:\/\//', $this->attributes['thumb'])) {
            $this->setAttribute('thumb', url('storage/'.$this->attributes['thumb']));
        }        
    }
    
    public function category()
    {        
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    public function amountOfSales()
    {
        $amountOfSales = SaleDetails::where('product', $this->id)->count();
        $this->setAttribute('amount_of_sales', $amountOfSales);        
    }

}