<?php

namespace Modules\ShowingRelease\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\ShowingRelease\Entities\ShowingRelease;
use Faker\Factory as Faker;

class ShowingReleaseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movies = Movie::all();
        $faker = Faker::create();
        // Random date in 2024
        $dateRelease = $faker->dateTimeBetween('2024-01-01', '2024-12-31')->format('Y-m-d');
        
        for($i = 0 ; $i < 80 ; $i++){
            foreach ($movies as $movie) {
                // Random date in 2024
                $startDate = max($movie->premiere_date, now()->format('Y-m-d'));
                $dateRelease = $faker->dateTimeBetween($startDate, '+10 days')->format('Y-m-d');
                // Random time in the day
                $minutes = [0, 30]; // random giờ đẹp
                $hour = $faker->numberBetween(9, 23);
                $minute = $faker->randomElement($minutes);
                $timeRelease = sprintf('%02d:%02d:00', $hour, $minute);

                $room = Room::inRandomOrder()->first();
                DB::table('showing_releases')->insert([
                    'movie_id' => $movie->id,
                    'room_id' => $room->id,
                    'time_release' => $dateRelease . ' ' . $timeRelease,
                    'date_release' => $dateRelease,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
