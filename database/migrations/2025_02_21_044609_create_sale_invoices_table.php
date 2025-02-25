<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
    });

    Schema::create('sale_invoice_items', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_number')->unique();
        $table->foreignId('sale_invoice_id')->constrained('sale_invoices')->onDelete('cascade');
        $table->foreignId('product_id')->constrained('products');
        $table->integer('quantity');
        $table->decimal('unit_price', 10, 2);
        $table->decimal('tax', 5, 2);
        $table->decimal('total_price', 10, 2);
        $table->timestamps();
    });
    }

    public function down()
{
    Schema::table('sale_invoices', function (Blueprint $table) {
        $table->dropColumn('invoice_date');
    });
}
};
// $table->dateTime('invoice_date')->nullable();


