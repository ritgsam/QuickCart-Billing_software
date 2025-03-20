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
    Schema::table('sale_invoices', function (Blueprint $table) {
        $table->decimal('global_discount', 10, 2)->default(0)->after('total_amount');
    });

    Schema::table('purchase_invoices', function (Blueprint $table) {
        $table->decimal('global_discount', 10, 2)->default(0)->after('total_amount');
    });
}

public function down()
{
    Schema::table('sale_invoices', function (Blueprint $table) {
        $table->dropColumn('global_discount');
    });

    Schema::table('purchase_invoices', function (Blueprint $table) {
        $table->dropColumn('global_discount');
    });
}

};
