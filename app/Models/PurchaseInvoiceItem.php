<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItem extends Model
{
    use HasFactory;
protected $fillable = ['purchase_invoice_id', 'product_id', 'quantity', 'unit_price', 'gst_rate', 'discount','tax', 'total_price'];


    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class);
    }

    public function product()
{
    return $this->belongsTo(Products::class);
}

}
