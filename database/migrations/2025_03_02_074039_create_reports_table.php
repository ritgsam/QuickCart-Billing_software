<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    if (!Schema::hasTable('reports')) {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->json('data');
            $table->date('report_date');
            $table->timestamps();
        });
    }
}
};
