<?php

namespace Modules\Movie\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Movie\Entities\Movie;

class MovieDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movie::factory(35)->create();
    }
}