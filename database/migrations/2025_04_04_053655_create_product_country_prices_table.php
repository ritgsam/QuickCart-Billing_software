<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('product_country_prices', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->unsignedBigInteger('country_id');
        $table->decimal('price', 10, 2);
        $table->timestamps();

        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_country_prices');
    }
};
