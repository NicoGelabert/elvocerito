<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Client extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = ['name', 'image', 'image_mime', 'image_size', 'description', 'active', 'created_by', 'updated_by'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function parent()
    {
        return $this->belongsTo(Client::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public static function getActiveAsTree($resourceClassName = null)
    {
        $clients = Client::where('active', true)->orderBy('parent_id')->get();
        return self::buildClientTree($clients, null, $resourceClassName);
    }

    public static function getAllChildrenByParent(Client $client)
    {
        $client = Client::where('active', true)->orderBy('parent_id')->get();
        $result[] = $client;
        self::getClientsArray($clients, $client->id, $result);

        return $result;
    }

    private static function buildClientTree($clients, $parentId = null, $resourceClassName = null)
    {
        $clientTree = [];

        foreach ($clients as $client) {
            if ($client->parent_id === $parentId) {
                $children = self::buildClientTree($clients, $client->id, $resourceClassName);
                if ($children) {
                    $client->setAttribute('children', $children);
                }
                $clientTree[] = $resourceClassName ? new $resourceClassName($client) : $client;
            }
        }

        return $clientTree;
    }

    private static function getClientsArray($clients, $parentId, &$result)
    {
        foreach ($clients as $client) {
            if ($client->parent_id === $parentId) {
                $result[] = $client;
                self::getClientsArray($clients, $client->id, $result);
            }
        }
    }
}
