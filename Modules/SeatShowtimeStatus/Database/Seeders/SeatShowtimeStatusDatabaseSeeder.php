<?php

namespace Modules\SeatShowtimeStatus\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Seat\Entities\Seat;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;
use Modules\ShowingRelease\Entities\ShowingRelease;

class SeatShowtimeStatusDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //lấy hết các ShowingRelease
        $showtimes = ShowingRelease::all();
        foreach ($showtimes as $showtime) {
            // lấy các ghế ở phòng room_id
            $seats = Seat::where('room_id', $showtime->room_id)->get();
            foreach ($seats as $seat) {
                SeatShowtimeStatus::create([
                    'seat_id' => $seat->id,
                    'showtime_id' => $showtime->id,
                    'status' => false
                ]);
            }
        }
    }
}
