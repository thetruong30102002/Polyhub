<?php

namespace Modules\SeatType\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SeatTypeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        DB::table('seat_types')->insert([
            ['name' => 'Standard', 'price' => 200000],
            ['name' => 'VIP', 'price' => 300000],
            ['name' => 'Couple', 'price' => 400000],
        ]);
    }
}
