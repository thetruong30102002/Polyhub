<?php

namespace Modules\Attribute\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Attribute\Entities\Attribute;
use Modules\Movie\Entities\Movie;

class AttributeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movies = Movie::all();

        foreach ($movies as $movie) {
            DB::table('attributes')->insert([
                [
                    'name' => 'Image',
                    'movie_id' => $movie->id,
                    'created_at' => now(), 
                    'updated_at' => now()
                ],
                [
                    'name' => 'Trailer',
                    'movie_id' => $movie->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Rating',
                    'movie_id' => $movie->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Languge',
                    'movie_id' => $movie->id,
                    'created_at' => now(), 
                    'updated_at' => now()
                ],
            ]);
        }
    }
}
