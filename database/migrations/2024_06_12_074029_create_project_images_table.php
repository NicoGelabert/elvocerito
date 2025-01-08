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
        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects');
            $table->string('path', 255);
            $table->string('url', 255);
            $table->string('mime', 55);
            $table->integer('size');
            $table->integer('position')->nullable();
            $table->timestamps();
        });

        DB::table('projects')
            ->chunkById(100, function (Collection $projects) {
                $projects = $projects->map(function ($p) {
                    return [
                        'project_id' => $p->id,
                        'path' => '',
                        'url' => $p->image,
                        'mime' => $p->image_mime,
                        'size' => $p->image_size,
                        'position' => 1,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                    ];
                });

                DB::table('project_images')->insert($projects->all());

            });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('image_mime');
            $table->dropColumn('image_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('image', 2000)->nullable()->after('slug');
            $table->string('image_mime')->nullable()->after('image');
            $table->integer('image_size')->nullable()->after('image_mime');
        });

        DB::table('projects')
            ->select('id')
            ->chunkById(100, function (Collection $projects) {
                foreach ($projects as $project) {
                    $image = DB::table('project_images')
                        ->select(['project_id', 'url', 'mime', 'size'])
                        ->where('project_id', $project->id)
                        ->first();
                    if ($image) {
                        DB::table('projects')
                            ->where('id', $image->project_id)
                            ->update([
                                'image' => $image->url,
                                'image_mime' => $image->mime,
                                'image_size' => $image->size
                            ]);
                    }
                }
            });

        Schema::dropIfExists('project_images');
    }
};
