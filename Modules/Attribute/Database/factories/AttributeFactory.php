<?php
namespace Modules\Attribute\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Movie\Entities\Movie;


class AttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Attribute\Entities\Attribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'movie_id' => Movie::pluck('id')->random(),
            'name' => $this->faker->randomElement(['Image','Trailer']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

