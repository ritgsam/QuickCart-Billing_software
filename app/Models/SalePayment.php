<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{
    use HasFactory;
protected $fillable = [
        'sale_invoice_id',
        'customer_id',
        'payment_date',
        'amount_paid',
        'round_off',
        'balance_due',
        'discount',
        'gst',
        'payment_mode',
        'payment_method',
        'transaction_id',
        'status',
    ];
public function saleInvoice()
{
    return $this->belongsTo(SaleInvoice::class, 'sale_invoice_id');
}


    public function invoice()
    {
        return $this->belongsTo(SaleInvoice::class, 'sale_invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

