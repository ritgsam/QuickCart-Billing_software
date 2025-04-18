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
        Schema::create('purchase_transportations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('purchase_invoice_id')->constrained()->onDelete('cascade');
    $table->string('transporter_name')->nullable();
    $table->string('vehicle_number')->nullable();
    $table->date('dispatch_date')->nullable();
    $table->date('expected_delivery_date')->nullable();
    $table->string('status')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_transportations');
    }
};
