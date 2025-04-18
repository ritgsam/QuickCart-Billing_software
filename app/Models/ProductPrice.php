<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class ProductPrice extends Model
{
    protected $fillable = ['product_id', 'country_id', 'price'];

public function product()
{
    return $this->belongsTo(\App\Models\Product::class);
}

public function country() {
    return $this->belongsTo(Country::class);
}


}

