<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
    use HasFactory;

    protected $fillable = [
        'company_name', 'company_logo', 'company_address',
        'gst_number', 'invoice_prefix', 'invoice_terms', 'tax_rate'
    ];
}
