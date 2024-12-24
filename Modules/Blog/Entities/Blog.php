<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Entities\Category;

class Blog extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title',
        'short_desc',
        'content',
        'image',
        'categories_id',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\BlogFactory::new();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
