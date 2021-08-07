<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class WorkoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_workout()
    {
        $user = User::factory()->create();
        $baseUrl = env('APP_URL') . '/api/workouts';
    
        $this->actingAs($user);

        $workout = [
            "name" => "test workout",
            "duration" => 2160,
            "distance" => 3.0,
            "pace" => 0,
            "workout_type_id" => 1
        ];

        $response = $this->json('POST', $baseUrl . '/', $workout);
        $response->assertStatus(201);

        $this->assertEquals($workout["name"], $response["data"]["name"]);
        $this->assertEquals($workout["duration"], $response["data"]["duration"]);
        $this->assertEquals(
            $this->calculatePace(
                $workout["distance"],
                $workout["duration"]
            ), 
            $response["data"]["pace"]
        );
    }

    private function calculatePace($distance, $duration)
    {
        return ($duration / 60) / $distance;
    }
}
