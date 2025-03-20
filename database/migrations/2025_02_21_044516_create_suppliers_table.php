
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
    $table->id();
    $table->string('company_name');
    $table->string('email')->unique();
    $table->string('phone');
    $table->text('address')->nullable();
    $table->string('gst_number')->nullable();
    $table->string('payment_terms')->nullable();
    $table->timestamps();
});

    }

    public function down()
{
    Schema::table('purchase_invoices', function (Blueprint $table) {
        $table->dropForeign(['supplier_id']);
    });

    Schema::table('purchase_payments', function (Blueprint $table) {
        $table->dropForeign(['supplier_id']);
    });

    Schema::dropIfExists('suppliers');
}

}
