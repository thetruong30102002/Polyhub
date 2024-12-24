<?php

namespace Modules\Room\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cinema\Entities\Cinema;
use Modules\Seat\Entities\Seat;
use Modules\TicketSeat\Entities\TicketSeat;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "rooms";

    protected $fillable = ['name', 'cinema_id'];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function ticketSeat()
    {
        return $this->hasMany(TicketSeat::class);
    }
    
}
