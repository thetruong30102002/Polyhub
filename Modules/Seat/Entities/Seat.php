<?php

namespace Modules\Seat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Room\Entities\Room;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;
use Modules\SeatType\Entities\SeatType;

class Seat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['row', 'column','status', 'type', 'room_id'];

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function seatShowtimeStatuses()
    {
        return $this->hasMany(SeatShowtimeStatus::class);
    }
    public function seatType()
    {
        return $this->belongsTo(SeatType::class, 'seat_type_id');
    }
}
