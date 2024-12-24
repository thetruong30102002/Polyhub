<?php

// namespace Modules\Actor\Entities;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

// class Actor extends Model
// {
//     use HasFactory;
//     use SoftDeletes;
//     protected $table = 'actors';

//     protected $fillable = [
//         'id',	'name',	'gender',	'avatar',	'movie_id',	'created_at',	'updated_at',	

//     ];
    
//     public $timestamp = true;
//     protected static function newFactory()
//     {
//         return \Modules\Actor\Database\factories\ActorFactory::new();
//     }




namespace Modules\Actor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Movie\Entities\Movie;

class Actor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'actors';

    protected $fillable = [
        'id', 'name', 'gender', 'avatar', 'created_at', 'updated_at'
    ];

    public $timestamps = true; // sửa lại 'timestamp' thành 'timestamps'

    protected static function newFactory()
    {
        return \Modules\Actor\Database\factories\ActorFactory::new();
    }

    /**
     * The movies that belong to the actor.
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'actor_movie');
    }
}


