<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    use HasFactory;

protected $fillable = [
    'name', 'email', 'phone', 'address', 'city', 'state', 'postal_code', 'gst_number'
];

    public function saleInvoices() {
        return $this->hasMany(SaleInvoice::class);
    }
 public function categories()
    {
        return $this->hasManyThrough(Categories::class, Products::class, 'customer_id', 'id', 'id', 'category_id');
    }
}
