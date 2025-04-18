<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseTransportation extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_invoice_id',
        'transporter_name',
        'vehicle_number',
        'dispatch_date',
        'expected_delivery_date',
        'status',
    ];

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class);
    }
}

