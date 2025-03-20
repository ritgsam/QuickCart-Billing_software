<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('purchase_payments', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_payments', 'date')) {
                $table->dropColumn('date'); 
            }
        });
    }

    public function down()
    {
        Schema::table('purchase_payments', function (Blueprint $table) {
            $table->date('date')->nullable();
        });
    }
};

