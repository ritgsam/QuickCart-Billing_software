<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('company_name');
                $table->string('company_logo')->nullable();
                $table->text('company_address')->nullable();
                $table->string('gst_number')->nullable();
                $table->string('invoice_prefix')->default('INV-');
                $table->text('invoice_terms')->nullable();
                $table->decimal('tax_rate', 5, 2)->default(0);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
