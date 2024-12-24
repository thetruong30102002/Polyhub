<?php

namespace Modules\City\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CityDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            ['name' => 'Hà Nội'],
            ['name' => 'Hồ Chí Minh'],
            ['name' => 'Đà Nẵng'],
            ['name' => 'Hải Dương'],
            ['name' => 'Hải Phòng'],
        ]);
    }
}
