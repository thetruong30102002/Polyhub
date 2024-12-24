<?php

namespace Modules\Director\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Director\Entities\Director;

class DirectorDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('directors')->insert([
            [
                'name' => 'John Doe',
                'age' => 30,
                'date_of_birth' => '1993-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'age' => 25,
                'date_of_birth' => '1998-02-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Johnson',
                'age' => 28,
                'date_of_birth' => '1996-05-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
