<?php

namespace Modules\Movie\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Director\Entities\Director;
use Modules\Movie\Entities\Movie;

class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $directorIds = Director::pluck('id')->toArray();
        
        if (empty($directorIds)) {
            throw new \Exception('No directors found in the database. Please seed directors first.');
        }

        return [
            'name' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(),
            'duration' => $this->faker->numberBetween(60, 180),
            'premiere_date' => $this->faker->date(),
            'photo' => 'images/hinh-nen-dien-thoai-4k-6.jpg',
            'director_id' => $this->faker->randomElement($directorIds),
        ];
    }
}

