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
    Schema::create('transportations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sale_invoice_id')->constrained()->onDelete('cascade');
        $table->string('transporter_name');
        $table->string('vehicle_number');
        $table->date('dispatch_date');
        $table->date('expected_delivery_date')->nullable();
        $table->string('status')->default('Pending'); 
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
        Schema::dropIfExists('transportations');
    }
};
