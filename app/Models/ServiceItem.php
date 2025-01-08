<?php

namespace App\Models;

use App\Models\Service;
use App\Models\Client;
use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ServiceItem extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;
    
    protected $fillable = ['title', 'desciption', 'published', 'service_id', 'created_by', 'updated_by'];

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
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class, 'portfolio_service_item', 'service_item_id', 'portfolio_id');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::clas, 'client_service_item', 'service_item_id', 'client_id');
    }
}
