<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('category_id')->nullable();
                $table->decimal('purchase_price', 10, 2);
                $table->decimal('selling_price', 10, 2);
                $table->integer('stock_quantity')->default(0);
                $table->decimal('gst_amount', 10, 2)->nullable();
                $table->decimal('gst_rate', 5, 2)->default(0);
                $table->decimal('discount', 5, 2)->default(0);
                $table->decimal('tax_rate', 5, 2)->default(0);
                $table->string('hsn_code')->nullable();
                $table->boolean('visibility')->default(true);
                $table->string('sku', 255)->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->timestamps();

                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            });
        }

        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'stock_quantity')) {
                $table->integer('stock_quantity')->default(0)->after('selling_price');
            }
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable();
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            }
            if (!Schema::hasColumn('products', 'gst_rate')) {
                $table->decimal('gst_rate', 5, 2)->default(0)->after('stock_quantity');
            }
            if (!Schema::hasColumn('products', 'discount')) {
                $table->decimal('discount', 5, 2)->default(0)->after('gst_rate');
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'stock_quantity')) {
                $table->dropColumn('stock_quantity');
            }
            if (Schema::hasColumn('products', 'category_id')) {
                DB::statement('ALTER TABLE products DROP FOREIGN KEY IF EXISTS products_category_id_foreign');
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('products', 'gst_rate')) {
                $table->dropColumn('gst_rate');
            }
            if (Schema::hasColumn('products', 'discount')) {
                $table->dropColumn('discount');
            }
            if (Schema::hasColumn('products', 'purchase_price')) {
                $table->dropColumn('purchase_price');
            }
            if (Schema::hasColumn('products', 'selling_price')) {
                $table->dropColumn('selling_price');
            }
            if (Schema::hasColumn('products', 'visibility')) {
                $table->dropColumn('visibility');
            }
            if (Schema::hasColumn('products', 'tax_rate')) {
                $table->dropColumn('tax_rate');
            }
            if (Schema::hasColumn('products', 'hsn_code')) {
                $table->dropColumn('hsn_code');
            }
            if (Schema::hasColumn('products', 'sku')) {
                $table->dropColumn('sku');
            }
            if (Schema::hasColumn('products', 'price')) {
                $table->dropColumn('price');
            }
        });

        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
