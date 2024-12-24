<?php

namespace Modules\Room\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoomDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'name' => 'Room 1',
                'cinema_id' => 1, // Thay đổi ID này theo ID của các rạp chiếu phim trong bảng cinemas của bạn
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Room 2',
                'cinema_id' => 2, // Thay đổi ID này theo ID của các rạp chiếu phim trong bảng cinemas của bạn
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Room 3',
                'cinema_id' => 3, // Thay đổi ID này theo ID của các rạp chiếu phim trong bảng cinemas của bạn
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
