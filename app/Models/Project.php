<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Project extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasSlug;

    protected $fillable = ['title', 'image', 'image_mime', 'image_size', 'description', 'created_by', 'updated_by'];

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
    
    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('position');
    }

    public function getImageAttribute()
    {
        return $this->images->count() > 0 ? $this->images->get(0)->url : null;
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'project_services');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'project_tags');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'project_clients');
    }
}
