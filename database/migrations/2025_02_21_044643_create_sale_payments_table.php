<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('sale_payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sale_invoice_id')->constrained('sale_invoices')->onDelete('cascade');
        $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
        $table->date('payment_date');
        $table->decimal('amount_paid', 10, 2);
        $table->decimal('round_off', 10, 2)->default(0);
        $table->decimal('balance_due', 10, 2);
        $table->string('payment_mode');
        $table->string('transaction_id')->nullable();
        $table->string('status')->default('Pending');
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('sale_payments');
    }
};


