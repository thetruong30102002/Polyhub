<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Actor\Database\Seeders\ActorDatabaseSeeder;
use Modules\Attribute\Database\Seeders\AttributeDatabaseSeeder;
use Modules\AttributeValue\Database\Seeders\AttributeValueDatabaseSeeder;
use Modules\Blog\Database\Seeders\BlogDatabaseSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\Cinema\Database\Seeders\CinemaDatabaseSeeder;
use Modules\CinemaType\Database\Seeders\CinemaTypeDatabaseSeeder;
use Modules\City\Database\Seeders\CityDatabaseSeeder;
use Modules\Director\Database\Seeders\DirectorDatabaseSeeder;
use Modules\FoodCombo\Database\Seeders\FoodComboDatabaseSeeder;
use Modules\Movie\Database\Seeders\MovieCategoryTableSeeder;
use Modules\Movie\Database\Seeders\MovieDatabaseSeeder;
use Modules\Room\Database\Seeders\RoomDatabaseSeeder;
use Modules\Seat\Database\Seeders\SeatDatabaseSeeder;
use Modules\SeatShowtimeStatus\Database\Seeders\SeatShowtimeStatusDatabaseSeeder;
use Modules\SeatType\Database\Seeders\SeatTypeDatabaseSeeder;
use Modules\ShowingRelease\Database\Seeders\ShowingReleaseDatabaseSeeder;
use Modules\Voucher\Database\Seeders\VoucherDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'SupperAdmin',
            'email' => 'supper@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'user_type' => 'supper',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Employee',
            'email' => 'employee@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'user_type' => 'employee',
            'remember_token' => Str::random(10),
        ]);
         // Tạo một tài khoản client
         User::create([
            'name' => 'Client',
            'email' => 'client@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'user_type' => 'client',
            'remember_token' => Str::random(10),
        ]);
        User::factory()->count(10)->create();
        $this->call([
            CityDatabaseSeeder::class,
            CinemaDatabaseSeeder::class,
            CinemaTypeDatabaseSeeder::class,
            RoomDatabaseSeeder::class,
            SeatTypeDatabaseSeeder::class,
            SeatDatabaseSeeder::class,
            DirectorDatabaseSeeder::class,
            CategoryDatabaseSeeder::class,
            MovieDatabaseSeeder::class,
            MovieCategoryTableSeeder::class,
            AttributeDatabaseSeeder::class,
            AttributeValueDatabaseSeeder::class,
            ShowingReleaseDatabaseSeeder::class,
            BlogDatabaseSeeder::class,
            SeatShowtimeStatusDatabaseSeeder::class,
            FoodComboDatabaseSeeder::class,
            ActorDatabaseSeeder::class,
            VoucherDatabaseSeeder::class,
        ]);
    }
}
