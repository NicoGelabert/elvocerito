<?php

namespace App\Models;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['category', 'question', 'answer', 'published', 'created_by', 'updated_by'];

}
