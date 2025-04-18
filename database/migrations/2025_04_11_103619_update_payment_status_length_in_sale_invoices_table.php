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
        $table->string('payment_status', 20)->change();
    });
}

public function down()
{
    Schema::table('sale_invoices', function (Blueprint $table) {
        $table->string('payment_status', 10)->change();
    });
}

};
