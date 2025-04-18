<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('purchase_invoices', function (Blueprint $table) {
        $table->decimal('sgst_total', 10, 2)->default(0)->after('discount_total');
        $table->decimal('cgst_total', 10, 2)->default(0)->after('sgst_total');
        $table->decimal('igst_total', 10, 2)->default(0)->after('cgst_total');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
{
    Schema::table('purchase_invoices', function (Blueprint $table) {
        $table->dropColumn(['sgst_total', 'cgst_total', 'igst_total']);
    });
}

};
