<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_invoice_id',
        'transporter_name',
        'vehicle_number',
        'dispatch_date',
        'expected_delivery_date',
        'status',
    ];

    public function saleInvoice()
    {
        return $this->belongsTo(SaleInvoice::class);
    }
}
