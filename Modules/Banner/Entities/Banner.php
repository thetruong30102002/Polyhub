<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'note',
        'status'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Banner\Database\factories\BannerFactory::new();
    }
}
