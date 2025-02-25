<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    use HasFactory;

    // protected $fillable = ['invoice_number', 'customer_id', 'invoice_date', 'total_amount', 'discount', 'tax', 'final_amount', 'payment_status', 'due_date', 'invoice_notes', 'sales_executive_id'];
protected $fillable = [
    'customer_id', 'invoice_date', 'total_amount', 'discount',
    'tax', 'final_amount', 'payment_status', 'due_date',
    'invoice_notes', 'sales_executive_id', 'invoice_number'
];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            $invoice->invoice_number = 'SI' . str_pad(SaleInvoice::count() + 1, 6, '0', STR_PAD_LEFT);
        });
    }

    public function items()
    {
        return $this->hasMany(SaleInvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(SalePayment::class);
    }
}

