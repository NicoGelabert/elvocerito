<?php

use Illuminate\Support\Collection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('number', 10, 2);
            $table->text('size', 200);
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('description');
        });

        DB::table('products')
            ->select('id')
            ->chunkById(100, function (Collection $products) {
                foreach ($products as $product) {
                    $price = DB::table('product_prices')
                        ->select(['product_id', 'number', 'size'])
                        ->where('product_id', $product->id)
                        ->first();
                }
            });

        Schema::dropIfExists('product_prices');
    }
};
