<?php

namespace Modules\Movie\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;
use Modules\Movie\Entities\Movie;

class MovieCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();
        $movies = Movie::all();

        foreach ($movies as $movie) {
            // Lấy một số danh mục ngẫu nhiên
            $selectedCategories = $categories->random(rand(1, 3))->pluck('id');

            foreach ($selectedCategories as $categoryId) {
                DB::table('category_movie')->insert([
                    'category_id' => $categoryId,
                    'movie_id' => $movie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
