<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            // $table->date('invoice_date')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('tax', 8, 2)->nullable();
            $table->decimal('round_off', 10, places: 2)->default(0);
            $table->decimal('final_amount', 10, 2);
            $table->string('payment_status')->default('Unpaid');
            $table->date('due_date')->nullable();
            $table->text('invoice_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('purchase_invoices', function (Blueprint $table) {
            // $table->dropColumn('invoice_date');
            $table->dropColumn('round_off');
            $table->dropColumn('invoice_notes');
        });
    }
};
