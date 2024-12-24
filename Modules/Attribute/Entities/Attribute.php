<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AttributeValue\Entities\AttributeValue;
use Modules\Movie\Entities\Movie;
class Attribute extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'attributes';

    protected $fillable = [
        'id',	'movie_id',	'name',	'created_at',	'updated_at',	

    ];
    public $timestamp = true;

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    protected static function newFactory()
    {
        return \Modules\Attribute\Database\factories\AttributeFactory::new();
        // return \Modules\Actor\Database\factories\ActorFactory::new();
    }
    
}
