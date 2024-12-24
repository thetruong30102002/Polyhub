<?php

namespace Modules\ShowingRelease\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\Seat\Entities\Seat;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;
use Modules\Ticket\Entities\Ticket;
use Modules\TicketSeat\Entities\TicketSeat;

class ShowingRelease extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id',
    'room_id',
    'time_release',
    'date_release'];
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected static function newFactory()
    {
        return \Modules\ShowingRelease\Database\factories\ShowingReleaseFactory::new();
    }
    public function room(){
        return $this->belongsTo(Room::class,'room_id');
    }
    public function movie(){
        return $this->belongsTo(Movie::class,'movie_id');
    }

    public function ticketSeats()
    {
        return $this->hasMany(TicketSeat::class);
    }

    public function seatShowtimeStatuses()
    {
        return $this->hasMany(SeatShowtimeStatus::class,'showtime_id');
    }
 
}
