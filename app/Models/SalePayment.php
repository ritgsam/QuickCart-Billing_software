<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{
    use HasFactory;

    protected $fillable = ['sale_invoice_id', 'amount', 'payment_date', 'payment_method', 'round_off', 'balance_due', 'status'];

    public function invoice()
    {
        return $this->belongsTo(SaleInvoice::class);
    }
}

