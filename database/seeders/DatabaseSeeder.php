<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TrainingPlanSeeder;
use Database\Seeders\WorkoutTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TrainingPlanSeeder::class);
        $this->call(WorkoutTypeSeeder::class);   
    }
}
