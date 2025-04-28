<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tag extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'image', 'image_mime', 'image_size', 'active', 'parent_id', 'created_by', 'updated_by'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    
    public function parent()
    {
        return $this->belongsTo(Tag::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }

    public function article()
    {
        return $this->belongsToMany(Article::class);
    }

    public static function getActiveAsTree($resourceClassName = null)
    {
        $tags = Tag::where('active', true)->orderBy('parent_id')->get();
        return self::buildTagTree($tags, null, $resourceClassName);
    }

    public static function getAllChildrenByParent(Tag $tag)
    {
        $tag = Tag::where('active', true)->orderBy('parent_id')->get();
        $result[] = $tag;
        self::getTagsArray($tags, $tag->id, $result);

        return $result;
    }

    private static function buildTagTree($tags, $parentId = null, $resourceClassName = null)
    {
        $tagTree = [];

        foreach ($tags as $tag) {
            if ($tag->parent_id === $parentId) {
                $children = self::buildTagTree($tags, $tag->id, $resourceClassName);
                if ($children) {
                    $tag->setAttribute('children', $children);
                }
                $tagTree[] = $resourceClassName ? new $resourceClassName($tag) : $tag;
            }
        }

        return $tagTree;
    }

    private static function getTagsArray($tags, $parentId, &$result)
    {
        foreach ($tags as $tag) {
            if ($tag->parent_id === $parentId) {
                $result[] = $tag;
                self::getTagsArray($tags, $tag->id, $result);
            }
        }
    }
}
