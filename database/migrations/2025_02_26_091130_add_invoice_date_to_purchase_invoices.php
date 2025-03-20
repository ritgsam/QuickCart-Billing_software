<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::table('purchase_invoices', function (Blueprint $table) {
        $table->date('invoice_date')->nullable()->after('supplier_id');
    });
}

public function down()
{
    Schema::table('purchase_invoices', function (Blueprint $table) {
        $table->dropColumn('invoice_date');
    });
}
};
