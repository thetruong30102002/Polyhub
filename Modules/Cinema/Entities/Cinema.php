<?php

namespace Modules\Cinema\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\CinemaType\Entities\CinemaType;
use Modules\City\Entities\City;
use Modules\Room\Entities\Room;
use Modules\TicketSeat\Entities\TicketSeat;

class Cinema extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $model = 'cinemas';
    protected $fillable = ['name', 'rate_point', 'city_id'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function cinemaType(){
        return $this->belongsTo(CinemaType::class);
    }

    public function ticketSeat()
    {
        return $this->hasMany(TicketSeat::class);
    }
    
    // protected static function newFactory()
    // {
    //     return \Modules\Cinema\Database\factories\CinemaFactory::new();
    // }
}
