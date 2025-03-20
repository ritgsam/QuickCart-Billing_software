
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('sale_invoice_items')) {
            Schema::create('sale_invoice_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sale_invoice_id')->constrained('sale_invoices')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->integer('quantity')->default(1);
                $table->decimal('unit_price', 10, 2);
                $table->decimal('tax', 5, 2)->default(0);
                $table->decimal('total_price', 10, 2);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('sale_invoice_items');
    }
};
