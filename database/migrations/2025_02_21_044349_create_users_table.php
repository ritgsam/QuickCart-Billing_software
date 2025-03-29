<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up()
{
    if (!Schema::hasTable('users')) {
        Schema::create('users', function (Blueprint $table) {
             $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->enum('role', ['Admin', 'Manager', 'Accountant', 'Sales'])->default('Sales');
    $table->json('permissions')->nullable();
    $table->timestamp('last_login')->nullable();
    $table->boolean('status')->default(true);
    $table->timestamps();
        });
    }

    }
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
