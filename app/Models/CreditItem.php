<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_note_id',
        'product_id',
        'quantity',
        'unit_price',
        'tax_rate',
        'tax_price',
        'total'
    ];

    public function creditNote()
    {
        return $this->belongsTo(CreditNote::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}


