<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('title', 100)->nullable();
            $table->string('via', 50)->nullable();
            $table->string('via_name', 100)->nullable();
            $table->integer('via_number')->nullable();
            $table->string('address_unit', 20)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('province', 50)->nullable();
            $table->longText('link', 500)->nullable();
            $table->longText('google_maps', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_addresses');
    }
};
