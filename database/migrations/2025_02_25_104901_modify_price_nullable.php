<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->decimal('price', 8, 2)->nullable(); 
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('price');
    });
}
};
