<?php

namespace Modules\Movie\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Actor\Entities\Actor;
use Modules\Attribute\Entities\Attribute;
use Modules\AttributeValue\Entities\AttributeValue;
use Modules\Category\Entities\Category;
use Modules\Director\Entities\Director;
use Modules\ShowingRelease\Entities\ShowingRelease;
use Modules\TicketSeat\Entities\TicketSeat;

class Movie extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name', 'description', 'duration', 'premiere_date','photo','director_id'];
    
    protected static function newFactory()
    {
        return \Modules\Movie\Database\Factories\MovieFactory::new();
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_movie');
    }
    public function showingReleases()
    {
        return $this->hasMany(ShowingRelease::class);
    }
    
    public function attributeValues()
    {
        return $this->hasManyThrough(
            AttributeValue::class,
            Attribute::class,
            'movie_id',       // Foreign key on Attribute table...
            'attribute_id',   // Foreign key on AttributeValue table...
            'id',             // Local key on Movie table...
            'id'              // Local key on Attribute table...
        );
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_movie');
    }

    public function ticketseats(){
        return $this->hasMany(TicketSeat::class);    
    }
}
