<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

protected $fillable = ['supplier_id', 'invoice_date', 'total_amount', 'tax', 'round_off','discount', 'payment_status', 'due_date', 'invoice_notes','final_amount','invoice_number','global_discount'];

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
public function getFinalAmountAttribute()
{
    return ($this->items->sum('total_price') - $this->items->sum('discount_amount')) + $this->items->sum('gst_amount');
}
public function getBalanceDueAttribute()
{
    $totalPaid = $this->payments()->sum('amount_paid');
    return max(0, $this->total_amount - $totalPaid);
}
public function getPaymentStatusAttribute()
{
    $totalPaid = $this->payments()->sum('amount_paid');
    $balanceDue = $this->total_amount + $this->round_off - $totalPaid;

    if ($balanceDue <= 0) {
        return 'Paid';
    } elseif ($totalPaid > 0) {
        return 'Partial';
    } else {
        return 'Unpaid';
    }
}
public function calculateTotals()
{
    $subtotal = 0;
    $discount_total = 0;
    $gst_total = 0;

    foreach ($this->items as $item) {
        $total_price = ($item->unit_price * $item->quantity);
        $discount_amount = ($total_price * $item->discount) / 100;
        $total_price_after_discount = $total_price - $discount_amount;
        $gst_amount = ($total_price_after_discount * $item->gst) / 100;

        $subtotal += $total_price;
        $discount_total += $discount_amount;
        $gst_total += $gst_amount;
    }

    $global_discount = ($subtotal * $this->global_discount) / 100;
    $final_amount = ($subtotal - $discount_total - $global_discount) + $gst_total;

    $this->subtotal = $subtotal;
    $this->discount_total = $discount_total;
    $this->gst_total = $gst_total;
    $this->final_amount = $final_amount;
    $this->save();
}
}
