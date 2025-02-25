<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {
    use HasFactory;

    protected $fillable = ['company_name', 'email', 'phone', 'address', 'gst_number', 'payment_terms'];

    public function purchaseInvoices() {
        return $this->hasMany(PurchaseInvoice::class);
    }
}
