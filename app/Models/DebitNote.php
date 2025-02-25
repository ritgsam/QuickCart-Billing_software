<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitNote extends Model {
    use HasFactory;

    protected $fillable = ['purchase_invoice_id', 'supplier_id', 'round_off', 'actual_amount', 'tax_amount', 'total_amount'];

    public function purchaseInvoice() {
        return $this->belongsTo(PurchaseInvoice::class);
    }
}
