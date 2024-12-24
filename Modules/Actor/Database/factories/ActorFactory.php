<?php
namespace Modules\Actor\Database\factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Movie\Entities\Movie;
class ActorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Actor\Entities\Actor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'avatar' => $this->faker->imageUrl($width = 640, $height = 480, 'casts'),
            'created_at' => now(),
            'updated_at' => now()   
        ];
    }
}

