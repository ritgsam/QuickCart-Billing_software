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
    Schema::table('sale_invoice_items', function (Blueprint $table) {
        $table->decimal('gst_rate', 5, 2)->default(0)->after('unit_price');
        $table->decimal('discount', 5, 2)->default(0)->after('gst_rate');
    });
}

public function down()
{
    Schema::table('sale_invoice_items', function (Blueprint $table) {
        $table->dropColumn(['gst_rate', 'discount']);
    });
}

};
