<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'active', 'parent_id', 'image', 'image_mime', 'image_size', 'created_by', 'updated_by'];

    public function parent()
    {
        return $this->belongsTo(Author::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class); // article_author
    }

    public static function getActiveAsTree($resourceClassName = null)
    {
        $authors = Author::where('active', true)->orderBy('parent_id')->get();
        return self::buildAuthorTree($authors, null, $resourceClassName);
    }

    public static function getAllChildrenByParent(Author $author)
    {
        $authors = Author::where('active', true)->orderBy('parent_id')->get();
        $result[] = $author;
        self::getAuthorsArray($authors, $author->id, $result);

        return $result;
    }

    private static function buildAuthorTree($authors, $parentId = null, $resourceClassName = null)
    {
        $authorTree = [];

        foreach ($authors as $author) {
            if ($author->parent_id === $parentId) {
                $children = self::buildAuthorTree($authors, $author->id, $resourceClassName);
                if ($children) {
                    $author->setAttribute('children', $children);
                }
                $authorTree[] = $resourceClassName ? new $resourceClassName($author) : $author;
            }
        }

        return $authorTree;
    }

    private static function getAuthorsArray($authors, $parentId, &$result)
    {
        foreach ($authors as $author) {
            if ($author->parent_id === $parentId) {
                $result[] = $author;
                self::getAuthorsArray($authors, $author->id, $result);
            }
        }
    }
}
