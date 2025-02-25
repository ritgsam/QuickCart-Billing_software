<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNotesTable extends Migration
{
    public function up()
    {
        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_invoice_id');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('round_off', 10, 2)->default(0);
            $table->decimal('actual_amount', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();

            $table->foreign('sale_invoice_id')
                  ->references('id')->on('sale_invoices')
                  ->onDelete('cascade');
            $table->foreign('customer_id')
                  ->references('id')->on('customers')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_notes');
    }
}
