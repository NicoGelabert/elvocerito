<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'short_description',
        'description', 
        'leading_home',
        'leading_category',
        'urgencies',
        'client_number',
        'published',
        'created_by',
        'updated_by'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function getImageAttribute()
    {
        return $this->images->count() > 0 ? $this->images->get(0)->url : null;
    }

    public function contacts()
    {
        return $this->hasMany(ProductContact::class);
    }

    public function socials()
    {
        return $this->hasMany(ProductSocial::class);
    }

    public function addresses()
    {
        return $this->hasMany(ProductAddress::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function horarios()
    {
        return $this->hasMany(ProductHorario::class);
    }

    public function webs()
    {
        return $this->hasMany(ProductWeb::class);
    }

    public function listitems()
    {
        return $this->hasMany(ProductListitem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

