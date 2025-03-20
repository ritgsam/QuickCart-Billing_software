<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('purchase_invoices', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_invoices', 'final_amount')) {
                $table->dropColumn('final_amount');
            }
        });
    }

    public function down()
    {
        Schema::table('purchase_invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_invoices', 'final_amount')) {
                $table->decimal('final_amount', 10, 2)->default(0);
            }
        });
    }
};

