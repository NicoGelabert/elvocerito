<?php

namespace App\Models;

use App\Models\ServiceAttributes;
// use App\Models\Client;
// use App\Models\Portfolio;
// use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Service extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasSlug;

    protected $fillable = ['name', 'slug', 'icon', 'active', 'short_description', 'description', 'image', 'image_mime', 'image_size', 'parent_id', 'created_by', 'updated_by'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function parent()
    {
        return $this->belongsTo(Service::class);
    }

    public static function getActiveAsTree($resourceClassName = null)
    {
        $services = Service::where('active', true)->orderBy('parent_id')->get();
        return self::buildServiceTree($services, null, $resourceClassName);
    }

    public static function getAllChildrenByParent(Service $service)
    {
        $services = Service::where('active', true)->orderBy('parent_id')->get();
        $result[] = $service;
        self::getServicesArray($services, $service->id, $result);

        return $result;
    }

    private static function buildServiceTree($services, $parentId = null, $resourceClassName = null)
    {
        $serviceTree = [];

        foreach ($services as $service) {
            if ($service->parent_id === $parentId) {
                $children = self::buildServiceTree($services, $service->id, $resourceClassName);
                if ($children) {
                    $service->setAttribute('children', $children);
                }
                $serviceTree[] = $resourceClassName ? new $resourceClassName($service) : $service;
            }
        }

        return $serviceTree;
    }

    private static function getServicesArray($services, $parentId, &$result)
    {
        foreach ($services as $service) {
            if ($service->parent_id === $parentId) {
                $result[] = $service;
                self::getServicesArray($services, $service->id, $result);
            }
        }
    }

    public function attributes()
    {
        return $this->hasMany(ServiceAttributes::class);
    }

    // public function serviceItems()
    // {
    //     return $this->hasMany(ServiceItem::class);
    // }

    // public function clients()
    // {
    //     return $this->hasManyThrough(Client::class, ServiceItem::class);
    // }

    // public function portfolios()
    // {
    //     return $this->hasManyThrough(Portfolio::class, ServiceItem::Class, 'service_id', 'id', 'id', 'portfolio_id');
    // }

    // public function tags()
    // {
    //     return $this->hasMany(Tag::class);
    // }

}
