<?php

namespace Modules\TicketSeat\Entities;

use Modules\Bill\Entities\Bill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Cinema\Entities\Cinema;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;
use Modules\ShowingRelease\Entities\ShowingRelease;

class TicketSeat extends Model
{
    use HasFactory;

    protected $fillable = [
        'seat_id',
        'bill_id',
        'movie_id',
        'room_id',
        'cinema_id',
        'showing_release_id',
        'time_start',
        'price',
        'seat_showtime_status_id'];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function seat_showTime_status()
    {
        return $this->belongsTo(SeatShowtimeStatus::class, 'seat_showtime_status_id');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id');
    }

    public function showingRelease()
    {
        return $this->belongsTo(ShowingRelease::class, 'showing_release_id');
    }

    // protected static function newFactory()
    // {
    //     return \Modules\TicketSeat\Database\factories\TicketSeatFactory::new();
    // }
}
