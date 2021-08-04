<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrainingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planName = "12 week half-marathon";

        DB::table('training_plans')->truncate();

        for ($week = 1; $week <= 12; $week++) {

            for ($day = 1; $day <= 7; $day++) {

                DB::table('training_plans')->insert([
                    'name' => $planName,
                    'day' => $day,
                    'week' => $week,
                    'distance' => $this->getDayMilage($day, $week),
                    'created_at' => Carbon::now()
                ]);

            };

        };
    }

    private function getDayMilage($dayNumber, $week)
    {
        $weekdays = [3,4,5];
        if (in_array($dayNumber, $weekdays)) {
            return 3;
        } elseif ($dayNumber === 7) {
            return ($week * 2);
        } else {
            return 0;
        }
    }
}
