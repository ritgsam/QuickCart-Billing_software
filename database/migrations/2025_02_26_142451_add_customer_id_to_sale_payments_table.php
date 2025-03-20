<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('sale_payments', function (Blueprint $table) {
        if (!Schema::hasColumn('sale_payments', 'customer_id')) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
        }
    });
}

public function down()
{
    Schema::table('sale_payments', function (Blueprint $table) {
        $table->dropForeign(['customer_id']); 
        $table->dropColumn('customer_id');
    });
}
};
