<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('round_off', 10, 2)->default(0);
            $table->decimal('actual_total', 10, 2);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('payment_method');
            $table->string('status');
            $table->timestamps();

            $table->foreign('supplier_id')
                  ->references('id')->on('suppliers')
                  ->onDelete('cascade');
        });
    }

    public function down()
{
    Schema::table('purchase_invoices', function (Blueprint $table) {
        $table->dropColumn('total_amount');
    });
}


}

