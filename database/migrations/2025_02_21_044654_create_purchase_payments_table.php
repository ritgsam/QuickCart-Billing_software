<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     public function up()
//     {
//         Schema::create('purchase_payments', function (Blueprint $table) {
//             $table->id();
//             $table->unsignedBigInteger('purchase_invoice_id');
//             $table->unsignedBigInteger('supplier_id');
//             $table->date('payment_date')->default(now());
//             $table->decimal('amount_paid', 10, 2);
//             $table->decimal('discount', 10, 2)->default(0);
//             $table->decimal('gst', 10, 2)->default(0);
//             $table->decimal('round_off', 10, 2)->default(0);
//             $table->decimal('balance_due', 10, 2);
//             $table->string('payment_mode');
//             $table->string('transaction_id')->nullable();
//             $table->string('status');
//             $table->timestamps();

//             $table->foreign('purchase_invoice_id')->references('id')->on('purchase_invoices')->onDelete('cascade');
//             $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
//         });
//     }

//     public function down()
//     {
//         Schema::dropIfExists('purchase_payments');
//     }
// };
//
//

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Facades\DB;

// return new class extends Migration {
//     public function up()
//     {
//         Schema::create('purchase_payments', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('purchase_invoice_id')->constrained('purchase_invoices')->onDelete('cascade');
//             $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
//             $table->date('payment_date')->default(DB::raw('CURRENT_DATE'));
//             $table->decimal('amount_paid', 10, 2);
//             $table->decimal('discount', 10, 2)->default(0);
//             $table->decimal('gst', 10, 2)->default(0);
//             $table->decimal('round_off', 10, 2)->default(0);
//             $table->decimal('balance_due', 10, 2)->nullable();
//             $table->string('payment_mode');
//             $table->string('transaction_id')->nullable();
//             $table->string('status')->default('Pending');
//             $table->timestamps();
//         });

//         // Ensure 'balance_due' column exists in case of an older table
//         Schema::table('purchase_payments', function (Blueprint $table) {
//             if (!Schema::hasColumn('purchase_payments', 'balance_due')) {
//                 $table->decimal('balance_due', 10, 2)->nullable()->after('round_off');
//             }
//         });

//         // Remove 'amount' column if it exists
//         Schema::table('purchase_payments', function (Blueprint $table) {
//             if (Schema::hasColumn('purchase_payments', 'amount')) {
//                 $table->dropColumn('amount');
//             }
//         });
//     }

//     public function down()
//     {
//         Schema::table('purchase_payments', function (Blueprint $table) {
//             if (!Schema::hasColumn('purchase_payments', 'amount')) {
//                 $table->decimal('amount', 10, 2)->nullable();
//             }
//         });

//         Schema::table('purchase_payments', function (Blueprint $table) {
//             if (Schema::hasColumn('purchase_payments', 'balance_due')) {
//                 $table->dropColumn('balance_due');
//             }
//         });

//         Schema::table('purchase_payments', function (Blueprint $table) {
//             $table->dropForeign(['purchase_invoice_id']);
//             $table->dropForeign(['supplier_id']);
//         });

//         Schema::dropIfExists('purchase_payments');
//     }
// };
//

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_invoice_id')->constrained('purchase_invoices')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->date('payment_date')->default(DB::raw('CURRENT_DATE'));
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('gst', 10, 2)->default(0);
            $table->decimal('round_off', 10, 2)->default(0);
            $table->decimal('balance_due', 10, 2)->nullable();
            $table->string('payment_mode');
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });

        // Ensure 'balance_due' column exists in case of an older table
        Schema::table('purchase_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_payments', 'balance_due')) {
                $table->decimal('balance_due', 10, 2)->nullable()->after('round_off');
            }
        });

        // Remove 'amount' column if it exists
        Schema::table('purchase_payments', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_payments', 'amount')) {
                $table->dropColumn('amount');
            }
        });

        // Remove 'date' column if it exists
        Schema::table('purchase_payments', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_payments', 'date')) {
                $table->dropColumn('date');
            }
        });
    }

    public function down()
    {
        Schema::table('purchase_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_payments', 'amount')) {
                $table->decimal('amount', 10, 2)->nullable();
            }
        });

        Schema::table('purchase_payments', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_payments', 'balance_due')) {
                $table->dropColumn('balance_due');
            }
        });

        Schema::table('purchase_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_payments', 'date')) {
                $table->date('date')->nullable();
            }
        });

        Schema::table('purchase_payments', function (Blueprint $table) {
            $table->dropForeign(['purchase_invoice_id']);
            $table->dropForeign(['supplier_id']);
        });

        Schema::dropIfExists('purchase_payments');
    }
};

