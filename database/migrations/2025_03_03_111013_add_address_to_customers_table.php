<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::table('customers', function (Blueprint $table) {
        if (!Schema::hasColumn('customers', 'address')) {
            $table->text('address')->nullable()->after('phone');
        }
    });
}

public function down()
{
    Schema::table('customers', function (Blueprint $table) {
        if (Schema::hasColumn('customers', 'address')) {
            $table->dropColumn('address');
        }
    });
}
};
