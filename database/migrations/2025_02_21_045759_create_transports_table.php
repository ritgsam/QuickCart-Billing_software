<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportsTable extends Migration
{
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_invoice_id');
            $table->string('transporter_name');
            $table->string('vehicle_number');
            $table->date('dispatch_date');
            $table->date('expected_delivery_date');
            $table->string('status');
            $table->timestamps();

            $table->foreign('sale_invoice_id')
                  ->references('id')->on('sale_invoices')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transports');
    }
}
