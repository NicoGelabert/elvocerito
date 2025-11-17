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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->string('last_name');
            $table->string('email');
            $table->decimal('rating', 2, 1); // permite valores como 3.4
            $table->text('comment');
            $table->string('token')->unique(); // token de verificación
            $table->boolean('email_verified')->default(false);
            $table->boolean('published')->default(false);
            $table->text('admin_response')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
