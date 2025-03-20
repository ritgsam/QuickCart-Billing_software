<?php
    use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::table('sale_payments', function (Blueprint $table) {
        if (!Schema::hasColumn('sale_payments', 'transaction_id')) {
            $table->string('transaction_id')
                  ->nullable()
                  ->after('payment_mode'); 
        }
    });
}

public function down()
{
    Schema::table('sale_payments', function (Blueprint $table) {
        $table->dropColumn('transaction_id');
    });
}
};
