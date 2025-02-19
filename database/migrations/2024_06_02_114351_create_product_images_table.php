<?php

use Illuminate\Support\Collection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->string('path', 255);
            $table->string('url', 255);
            $table->string('mime', 55);
            $table->integer('size');
            $table->integer('position')->nullable();
            $table->timestamps();
        });

        DB::table('products')
            ->chunkById(100, function (Collection $products) {
                $products = $products->map(function ($p) {
                    return [
                        'product_id' => $p->id,
                        'path' => '',
                        'url' => $p->image,
                        'mime' => $p->image_mime,
                        'size' => $p->image_size,
                        'position' => 1,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                    ];
                });

                DB::table('product_images')->insert($products->all());

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
