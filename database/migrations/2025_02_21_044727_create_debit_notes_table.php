<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('debit_notes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('purchase_invoice_id')->constrained('purchase_invoices')->onDelete('cascade');
        $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
        $table->date('debit_date');
            $table->string('debit_note_number')->unique()->nullable();
        $table->decimal('total_amount', 10, 2);
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}




    public function down()
    {
        Schema::dropIfExists('debit_notes');
    }
};

