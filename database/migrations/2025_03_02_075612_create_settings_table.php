<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->string('company_email');
            $table->string('company_phone');
            $table->string('company_contact')->nullable();
            $table->text('company_address');
            $table->string('business_name')->nullable();
            $table->text('business_address')->nullable();
            $table->string('business_state')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('invoice_prefix')->default('INV-');
            $table->text('invoice_terms')->nullable();
            $table->decimal('default_tax_rate', 5, 2)->default(18.00);
            $table->json('roles_permissions')->nullable();
        $table->boolean('status')->default(true)->change();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('settings');
    }
};
