<?php

namespace Modules\CinemaType\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Cinema\Entities\Cinema;

class CinemaTypeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cinemas = Cinema::all();

        foreach ($cinemas as $cinema) {
            DB::table('cinema_types')->insert([
                [
                    'name' => 'Rạp 2D',
                    'cinema_id' => $cinema->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Rạp LAMOUR',
                    'cinema_id' => $cinema->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Rạp CINEFOREST',
                    'cinema_id' => $cinema->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}
