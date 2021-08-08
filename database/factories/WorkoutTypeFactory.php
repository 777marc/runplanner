<?php

namespace Database\Factories;

use App\Models\WorkoutType;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkoutType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence($nbWords = 3),
            'description' => $this->faker->sentence($nbWords = 3),
        ];
    }
}
