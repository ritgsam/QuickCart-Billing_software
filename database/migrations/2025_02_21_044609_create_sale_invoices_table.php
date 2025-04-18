<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->nullable();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->date('invoice_date');
    // $table->decimal('subtotal', 10, 2);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('tax', 5, 2)->default(0);
            $table->decimal('gst_rate', 5, 2)->default(0);
$table->decimal('final_amount', 10, 2)->default(0);
$table->decimal('round_off', 10, 2)->default(0);
$table->decimal('global_discount', 5, 2)->default(0);
            $table->enum('payment_status', ['Paid', 'Unpaid', 'Partial'])->default('Unpaid');
            $table->date('due_date')->nullable();
            $table->text('invoice_notes')->nullable();
            $table->foreignId('sales_executive_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::table('sale_invoices', function (Blueprint $table) {
            // if (Schema::hasColumn('sale_invoices', 'final_amount')) {
            //     $table->dropColumn('final_amount');
            // }
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_invoices');

        Schema::table('sale_invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_invoices', 'final_amount')) {
                $table->decimal('final_amount', 10, 2)->default(0);
            }
        });
    }
};


