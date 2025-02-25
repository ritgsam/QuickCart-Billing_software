<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = ['sale_invoice_id', 'product_id', 'quantity', 'unit_price', 'tax', 'total_price'];

    public function invoice()
    {
        return $this->belongsTo(SaleInvoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
