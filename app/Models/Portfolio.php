<?php

namespace App\Models;

use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Portfolio extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = ['title', 'image', 'image_mime', 'image_size', 'description', 'client_id', 'year', 'link', 'published', 'created_by', 'updated_by'];

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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function serviceItems()
    {
        return $this->belongsToMany(ServiceItem::class, 'portfolio_service_item', 'portfolio_id', 'service_item_id');
    }

    public function services()
    {
        return $this->hasManyThrough(Service::class, ServiceItem::class);
    }
}
