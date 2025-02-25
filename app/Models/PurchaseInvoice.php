<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model {
    use HasFactory;

    protected $fillable = ['invoice_number', 'supplier_id', 'gst_tax_amount', 'round_off', 'actual_total', 'grand_total', 'payment_method', 'status'];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseInvoiceItems() {
        return $this->hasMany(PurchaseInvoiceItem::class);
    }

    public function purchasePayments() {
        return $this->hasMany(PurchasePayment::class);
    }

    public function debitNote() {
        return $this->hasOne(DebitNote::class);
    }
}
