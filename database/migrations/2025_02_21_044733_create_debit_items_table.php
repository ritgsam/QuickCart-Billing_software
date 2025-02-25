
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitItemsTable extends Migration
{
    public function up()
    {
        Schema::create('debit_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('debit_note_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('tax_rate', 5, 2);
            $table->decimal('tax_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('debit_note_id')
                  ->references('id')->on('debit_notes')
                  ->onDelete('cascade');
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('debit_items');
    }
}
