<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitNotesTable extends Migration
{
    public function up()
    {
        Schema::create('debit_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_invoice_id');
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('round_off', 10, 2)->default(0);
            $table->decimal('actual_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();

            $table->foreign('purchase_invoice_id')
                  ->references('id')->on('purchase_invoices')
                  ->onDelete('cascade');
            $table->foreign('supplier_id')
                  ->references('id')->on('suppliers')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('debit_notes');
    }
}
