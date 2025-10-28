<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'name', 'sku', 'category_id', 'purchase_price', 'selling_price', 'gst_rate', 'discount',
    'visibility', 'stock_quantity', 'tax_rate', 'hsn_code'
];

protected static function booted()
{
    static::creating(function ($product) {
        $product->sku = 'SKU-' . strtoupper(uniqid());
    });
}
public function prices()
{
    return $this->hasMany(ProductPrice::class);
}


public function productPrices()
{
    return $this->hasMany(\App\Models\ProductPrice::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

public function getCountryPrice($country)
{
    return $this->countryPrices()->where('country', $country)->value('price');
}

}



