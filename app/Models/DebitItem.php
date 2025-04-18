<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'debit_note_id',
        'product_id',
        'quantity',
        'unit_price',
        'tax_rate',
        'tax_price',
        'total',
    ];

    public function debitNote()
    {
        return $this->belongsTo(DebitNote::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}



