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
   public function up(): void
{
    Schema::table('sale_invoices', function (Blueprint $table) {
        $table->decimal('round_off', 10, 2)->default(0)->after('invoice_notes');
        $table->decimal('final_amount', 10, 2)->default(0)->after('round_off');
    });
}

public function down(): void
{
    Schema::table('sale_invoices', function (Blueprint $table) {
        $table->dropColumn(['round_off', 'final_amount', 'payment_status']);
    });
}

};
