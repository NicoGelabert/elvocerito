<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Alergen extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasSlug;

    protected $fillable = ['name', 'slug', 'description', 'image', 'image_mime', 'image_size', 'active', 'parent_id', 'created_by', 'updated_by'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function parent()
    {
        return $this->belongsTo(Alergen::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class); // product_alergen
    }

    public static function getActiveAsTree($resourceClassName = null)
    {
        $alergens = Alergen::where('active', true)->orderBy('parent_id')->get();
        return self::buildAlergenTree($alergens, null, $resourceClassName);
    }

    public static function getAllChildrenByParent(Alergen $alergen)
    {
        $alergens = Alergen::where('active', true)->orderBy('parent_id')->get();
        $result[] = $alergen;
        self::getAlergensArray($alergens, $alergen->id, $result);

        return $result;
    }

    private static function buildAlergenTree($alergens, $parentId = null, $resourceClassName = null)
    {
        $alergenTree = [];

        foreach ($alergens as $alergen) {
            if ($alergen->parent_id === $parentId) {
                $children = self::buildAlergenTree($alergens, $alergen->id, $resourceClassName);
                if ($children) {
                    $alergen->setAttribute('children', $children);
                }
                $alergenTree[] = $resourceClassName ? new $resourceClassName($alergen) : $alergen;
            }
        }

        return $alergenTree;
    }

    private static function getAlergensArray($alergens, $parentId, &$result)
    {
        foreach ($alergens as $alergen) {
            if ($alergen->parent_id === $parentId) {
                $result[] = $alergen;
                self::getAlergensArray($alergens, $alergen->id, $result);
            }
        }
    }
}
