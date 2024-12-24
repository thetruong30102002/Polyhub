<?php

namespace Modules\AttributeValue\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Entities\Attribute;

class AttributeValue extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'attribute_value';
    protected $fillable = [
        'id',	'attribute_id',	'value',	'created_at',	'updated_at',	
    ];
    public $timestamp = true;

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\AttributeValue\Database\factories\AttributeValueFactory::new();
    }
}
