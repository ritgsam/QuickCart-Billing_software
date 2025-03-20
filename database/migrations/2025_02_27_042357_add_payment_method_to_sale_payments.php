<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('sale_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_payments', 'payment_method')) {
                $table->string('payment_method')->default('Cash')->after('balance_due');
            }
        });
    }

    public function down()
    {
        Schema::table('sale_payments', function (Blueprint $table) {
            if (Schema::hasColumn('sale_payments', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
        });
    }
};
