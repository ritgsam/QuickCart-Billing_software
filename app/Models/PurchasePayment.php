<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model {
    use HasFactory;

    protected $fillable = [
        'purchase_invoice_id', 'supplier_id', 'payment_date',
        'amount_paid','discount', 'gst', 'round_off', 'balance_due', 'payment_mode',
        'transaction_id', 'status'
    ];

    public function purchaseInvoice() {
        return $this->belongsTo(PurchaseInvoice::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
}

