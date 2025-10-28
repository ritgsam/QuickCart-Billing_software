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
            $table->date('invoice_date')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('tax', 8, 2)->nullable();
            $table->decimal('discount_total', 10, 2)->nullable();
            $table->decimal('gst_total', 10, 2)->nullable();
            $table->decimal('sgst', 15, 2)->default(0);
            $table->decimal('cgst', 15, 2)->default(0);
            $table->decimal('igst', 15, 2)->default(0);
            $table->decimal('round_off', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);
            $table->string('payment_status')->default('paid');
            $table->date('due_date')->nullable();
            $table->text('invoice_notes')->nullable();
            $table->timestamps();
        });

        Schema::table('purchase_invoices', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_invoices', 'final_amount')) {
                $table->dropColumn('final_amount');
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_invoices');
    }
};
