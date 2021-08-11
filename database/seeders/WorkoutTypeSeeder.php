<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WorkoutTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('workout_types')->truncate();
        
        $workoutTypes = ['run', 'walk', 'cycle', 'strength'];

        foreach($workoutTypes as $workout) {
            DB::table('workout_types')->insert([
                'name' => $workout,
                'description' => Str::random(20),
            ]);
        }
    }
}
