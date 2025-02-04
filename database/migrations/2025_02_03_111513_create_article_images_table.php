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
        Schema::create('article_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles');
            $table->string('path', 255);
            $table->string('url', 255);
            $table->string('mime', 55);
            $table->integer('size');
            $table->integer('position')->nullable();
            $table->timestamps();
        });

        DB::table('articles')
            ->chunkById(100, function (Collection $articles) {
                $articles = $articles->map(function ($a) {
                    return [
                        'article_id' => $a->id,
                        'path' => '',
                        'url' => $a->image,
                        'mime' => $a->image_mime,
                        'size' => $a->image_size,
                        'position' => 1,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                    ];
                });

                DB::table('article_images')->insert($articles->all());

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_images');
    }
};
