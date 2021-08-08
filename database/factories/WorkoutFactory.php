<?php

namespace Database\Factories;

use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Workout::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence($nbWords = 3),
            'duration' => $this->faker->randomNumber,
            'distance' => $this->faker->randomFloat(2, 0, 10),
            'pace' => 0,
            'workout_type_id' => 1,
            'user_id' => 1,
            'created_at' => now()
        ];
    }
}
