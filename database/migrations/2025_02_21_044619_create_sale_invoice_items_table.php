
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoiceItemsTable extends Migration
{
    public function up()
    {
                if (!Schema::hasTable('sale_invoice_items')) {
        Schema::create('sale_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('sale_invoice_id')->constrained('sale_invoices')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();

            $table->foreign('sale_invoice_id')
                  ->references('id')->on('sale_invoices')
                  ->onDelete('cascade');
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
        });
    }
    }

    public function down()
    {
        Schema::dropIfExists('sale_invoice_items');
    }
}
