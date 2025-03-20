<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

protected $fillable = ['supplier_id', 'invoice_date', 'total_amount', 'tax', 'round_off', 'payment_status', 'due_date', 'invoice_notes', 'invoice_number','global_discount'];

protected static function boot()
    {
        parent::boot();
        static::creating(function ($invoice) {
            $lastInvoice = PurchaseInvoice::latest()->first();
            $nextNumber = $lastInvoice ? intval(substr($lastInvoice->invoice_number, 4)) + 1 : 1;
            $invoice->invoice_number = 'INV-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }

  public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function purchaseInvoice()
{
    return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
}


public function items()
{
    return $this->hasMany(PurchaseInvoiceItem::class, 'purchase_invoice_id');
}

public function payments()
    {
        return $this->hasMany(PurchasePayment::class, 'purchase_invoice_id');
    }
}
