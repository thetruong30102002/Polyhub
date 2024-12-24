<?php
namespace Modules\Director\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Director\Entities\Director;
class DirectorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Director::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name,
            'age' => fake()->numberBetween(25, 70),
            'date_of_birth' => fake()->date(),
        ];
    }
}

