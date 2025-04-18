<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('purchase_invoice_items', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('purchase_invoice_id');
        $table->unsignedBigInteger('product_id');
        $table->integer('quantity');
        $table->decimal('unit_price', 10, 2);
        // $table->decimal('gst_rate', 5, 2)->default(0);
        $table->decimal('discount', 5, 2)->default(0);
        $table->decimal('tax', 5, 2)->default(0);

            $table->decimal('sgst', 5, 2)->nullable();
            $table->decimal('cgst', 5, 2)->nullable();
            $table->decimal('igst', 5, 2)->nullable();

            $table->decimal('tax', 5, 2)->default(0)->after('unit_price');
        $table->decimal('total_price', 10, 2);
        $table->timestamps();

        $table->foreign('purchase_invoice_id')->references('id')->on('purchase_invoices')->onDelete('cascade');
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}

    public function down()
{
    Schema::table('purchase_invoice_items', function (Blueprint $table) {
        $table->dropColumn('discount');
        // $table->dropColumn('gst_rate');
    });
}
};
