<?php

namespace Modules\CinemaType\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Cinema\Entities\Cinema;

class CinemaType extends Model
{
    use HasFactory;

    protected $table = 'cinema_types';
    protected $fillable = ['name', 'cinema_id'];

    public function cinema(){
        return $this->belongsTo(Cinema::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\CinemaType\Database\factories\CinemaTypeFactory::new();
    }
}
