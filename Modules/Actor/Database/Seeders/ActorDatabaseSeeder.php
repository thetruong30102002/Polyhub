<?php

namespace Modules\Actor\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Actor\Entities\Actor;
class ActorDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Actor::factory()->count(20)->create();
    }
}
