<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeHeroBanner extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = ['image', 'image_mime', 'image_size', 'headline', 'description', 'link', 'created_by', 'updated_by'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('headline')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
