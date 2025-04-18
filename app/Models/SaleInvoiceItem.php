<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoiceItem extends Model
{
    use HasFactory;
protected $fillable = ['sale_invoice_id', 'product_id', 'quantity', 'unit_price', 'sgst', 'cgst', 'igst', 'discount', 'total_price'];

    public function saleInvoice()
{
    return $this->belongsTo(SaleInvoice::class, 'sale_invoice_id');
}



    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

