<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    use HasFactory;

protected $fillable = [
    'customer_id', 'invoice_date', 'due_date',
    'payment_status', 'global_discount', 'round_off',
    'final_amount', 'invoice_notes','transporter_name','total_amount','balance_due',
    'vehicle_number',
    'dispatch_date',
    'expected_delivery_date',
    'status'
];

protected static function boot()
    {
        parent::boot();
        static::creating(function ($invoice) {
            $lastInvoice = SaleInvoice::latest('id')->first();
            $invoice->invoice_number = 'INV-' . str_pad($lastInvoice ? $lastInvoice->id + 1 : 1, 4, '0', STR_PAD_LEFT);
        });
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function salesExecutive()
    {
        return $this->belongsTo(User::class, 'sales_executive_id');
    }

public function saleItems()
{
    return $this->hasMany(SaleInvoiceItem::class);
}
    public function items()
    {
        return $this->hasMany(SaleInvoiceItem::class);
    }

    public function payments()
{
    return $this->hasMany(SalePayment::class);
}

public function getBalanceDueAttribute()
{
    $paidAmount = $this->payments->sum('amount') + $this->payments->sum('round_off');
    return $this->total_amount - $paidAmount;
}
public function getTaxPercentageAttribute()
{
    return $this->tax ?? 0;
}

public function getDiscountPercentageAttribute()
{
    return $this->discount ?? 0;
}


public function transportation()
{
    return $this->hasOne(\App\Models\Transportation::class, 'sale_invoice_id');
}

}


