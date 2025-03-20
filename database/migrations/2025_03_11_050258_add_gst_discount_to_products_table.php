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
    Schema::table('products', function (Blueprint $table) {
        if (!Schema::hasColumn('products', 'gst_rate')) {
            $table->decimal('gst_rate', 5, 2)->default(0)->after('stock');
        }
        if (!Schema::hasColumn('products', 'discount')) {
            $table->decimal('discount', 5, 2)->default(0)->after('gst_rate');
        }
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        if (Schema::hasColumn('products', 'gst_rate')) {
            $table->dropColumn('gst_rate');
        }
        if (Schema::hasColumn('products', 'discount')) {
            $table->dropColumn('discount');
        }
    });
}

};
