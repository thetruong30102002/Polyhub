<?php
namespace Modules\AttributeValue\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Attribute\Entities\Attribute;
class AttributeValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\AttributeValue\Entities\AttributeValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'attribute_id' => Attribute::pluck('id')->random(),
            'value' => $this->faker->url,
            'created_at' => now(),
            'updated_at' => null
        ];
    }
}

