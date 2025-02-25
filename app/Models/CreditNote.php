<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model {
    use HasFactory;

    protected $fillable = ['sale_invoice_id', 'customer_id', 'round_off', 'actual_amount', 'tax_amount', 'total_amount'];

    public function saleInvoice() {
        return $this->belongsTo(SaleInvoice::class);
    }
}
