<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('sale_payments', function (Blueprint $table) {
        if (!Schema::hasColumn('sale_payments', 'payment_mode')) {
            $table->string('payment_mode')
                  ->after('balance_due'); 
        }
    });
}

public function down()
{
    Schema::table('sale_payments', function (Blueprint $table) {
        $table->dropColumn('payment_mode');
    });
}
};
