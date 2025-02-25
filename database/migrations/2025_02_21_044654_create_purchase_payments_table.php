<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_invoice_id');
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->string('payment_method');
            $table->decimal('round_off', 10, 2)->default(0);
            $table->decimal('actual_balance', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('status');
            $table->timestamps();

            $table->foreign('purchase_invoice_id')
                  ->references('id')->on('purchase_invoices')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_payments');
    }
}
