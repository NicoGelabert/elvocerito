<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasSlug;

    protected $fillable = ['name', 'slug', 'active', 'description', 'image', 'image_mime', 'image_size', 'parent_id', 'created_by', 'updated_by'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    public static function getActiveAsTree($resourceClassName = null)
    {
        $categories = Category::where('active', true)->orderBy('parent_id')->get();
        return self::buildCategoryTree($categories, null, $resourceClassName);
    }

    public static function getAllChildrenByParent(Category $category)
    {
        $categories = Category::where('active', true)->orderBy('parent_id')->get();
        $result[] = $category;
        self::getCategoriesArray($categories, $category->id, $result);

        return $result;
    }

    private static function buildCategoryTree($categories, $parentId = null, $resourceClassName = null)
    {
        $categoryTree = [];

        // Filtramos las hijas del parentId actual
        $children = $categories->filter(function ($category) use ($parentId) {
            return $category->parent_id === $parentId;
        });

        // Ordenamos las hijas alfabéticamente (insensible a mayúsculas opcionalmente)
        $children = $children->sortBy(fn($c) => mb_strtolower($c->name));

        foreach ($children as $category) {
            $childrenTree = self::buildCategoryTree($categories, $category->id, $resourceClassName);
            $category->setAttribute('children', collect($childrenTree));
            $categoryTree[] = $resourceClassName ? new $resourceClassName($category) : $category;
        }

        return $categoryTree;
    }


    private static function getCategoriesArray($categories, $parentId, &$result)
    {
        foreach ($categories as $category) {
            if ($category->parent_id === $parentId) {
                $result[] = $category;
                self::getCategoriesArray($categories, $category->id, $result);
            }
        }
    }

}
