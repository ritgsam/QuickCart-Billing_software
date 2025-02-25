<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
    'name', 'sku', 'category_id', 'purchase_price', 'selling_price',
    'visibility', 'stock', 'tax_rate', 'hsn_code'
];


    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}



