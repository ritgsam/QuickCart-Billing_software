<?php
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     public function up()
//     {
//         Schema::create('sale_payments', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('sale_invoice_id')->constrained('sale_invoices')->onDelete('cascade');
//             $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
//             $table->date('payment_date');
//             $table->decimal('amount_paid', 10, 2);
//             $table->decimal('discount', 10, 2)->default(0);
//             $table->decimal('gst', 8, 2)->default(0);
//             $table->decimal('round_off', 10, 2)->default(0);
//             $table->decimal('balance_due', 10, 2);
//             $table->string('payment_mode');
//             $table->string('transaction_id')->nullable();
//             $table->string('status')->default('Pending');
//             $table->timestamps();
//         });
//     }

//     public function down()
//     {
//         Schema::dropIfExists('sale_payments');
//     }
// };
//

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     public function up()
//     {
//         // Creating sale_payments table if it does not exist
//         if (!Schema::hasTable('sale_payments')) {
//             Schema::create('sale_payments', function (Blueprint $table) {
//                 $table->id();
//                 $table->foreignId('sale_invoice_id')->constrained('sale_invoices')->onDelete('cascade');
//                 $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
//                 $table->date('payment_date');
//                 $table->decimal('amount_paid', 10, 2);
//                 $table->decimal('discount', 10, 2)->default(0);
//                 $table->decimal('gst', 8, 2)->default(0);
//                 $table->decimal('round_off', 10, 2)->default(0);
//                 $table->decimal('balance_due', 10, 2);
//                 $table->string('payment_mode');
//                 $table->string('transaction_id')->nullable();
//                 $table->string('status')->default('Pending');
//                 $table->timestamps();
//             });
//         }

//         // Ensure customer_id column exists in case the table was already created before
//         if (Schema::hasTable('sale_payments') && !Schema::hasColumn('sale_payments', 'customer_id')) {
//             Schema::table('sale_payments', function (Blueprint $table) {
//                 $table->unsignedBigInteger('customer_id')->after('sale_invoice_id');
//                 $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
//             });
//         }
//     }

//     public function down()
//     {
//         // Dropping customer_id column safely
//         Schema::table('sale_payments', function (Blueprint $table) {
//             if (Schema::hasColumn('sale_payments', 'customer_id')) {
//                 $table->dropForeign(['customer_id']);
//                 $table->dropColumn('customer_id');
//             }
//         });

//         // Dropping the entire sale_payments table
//         Schema::dropIfExists('sale_payments');
//     }
// };
//
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('sale_payments')) {
            Schema::create('sale_payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sale_invoice_id')->constrained('sale_invoices')->onDelete('cascade');
                $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
                $table->date('payment_date');
                $table->decimal('amount_paid', 10, 2);
                $table->decimal('amount', 10, 2)->default(0); 
                $table->decimal('discount', 10, 2)->default(0);
                $table->decimal('gst', 8, 2)->default(0);
                $table->decimal('round_off', 10, 2)->default(0);
                $table->decimal('balance_due', 10, 2);
                $table->string('payment_mode');
                $table->string('transaction_id')->nullable();
                $table->string('status')->default('Pending');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('sale_payments') && !Schema::hasColumn('sale_payments', 'customer_id')) {
            Schema::table('sale_payments', function (Blueprint $table) {
                $table->unsignedBigInteger('customer_id')->after('sale_invoice_id');
                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            });
        }

        // Ensure transaction_id column exists
        if (Schema::hasTable('sale_payments') && !Schema::hasColumn('sale_payments', 'transaction_id')) {
            Schema::table('sale_payments', function (Blueprint $table) {
                $table->string('transaction_id')->nullable()->after('payment_mode');
            });
        }

        // Ensure amount column exists and update if necessary
        if (Schema::hasTable('sale_payments')) {
            Schema::table('sale_payments', function (Blueprint $table) {
                if (!Schema::hasColumn('sale_payments', 'amount')) {
                    $table->decimal('amount', 10, 2)->default(0);
                } else {
                    $table->decimal('amount', 10, 2)->default(0)->change();
                }
            });
        }
    }

    public function down()
    {
        Schema::table('sale_payments', function (Blueprint $table) {
            // Drop 'transaction_id' column safely
            if (Schema::hasColumn('sale_payments', 'transaction_id')) {
                $table->dropColumn('transaction_id');
            }

            // Drop 'customer_id' column safely
            if (Schema::hasColumn('sale_payments', 'customer_id')) {
                $table->dropForeign(['customer_id']);
                $table->dropColumn('customer_id');
            }

            // Drop 'amount' column safely
            if (Schema::hasColumn('sale_payments', 'amount')) {
                $table->dropColumn('amount');
            }
        });

        // Dropping the entire sale_payments table
        Schema::dropIfExists('sale_payments');
    }
};
