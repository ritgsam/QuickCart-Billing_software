<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sale_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_payments', 'amount')) {
                $table->decimal('amount', 10, 2)->default(0);
            }
            else {
                $table->decimal('amount', 10, 2)->default(0)->change();
            }
        });
    }

    public function down()
    {
        Schema::table('sale_payments', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->default(null)->change();
        });
    }
};
