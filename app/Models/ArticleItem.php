<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'article_id',
        'texto',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
