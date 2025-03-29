<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
    use HasFactory;

    protected $fillable = [
        'company_name', 'company_logo', 'company_email', 'company_phone',
        'company_address', 'gst_number', 'invoice_prefix', 'invoice_terms',
        'default_tax_rate', 'roles_permissions'
    ];

    protected $casts = [
        'roles_permissions' => 'array'
    ];
}
