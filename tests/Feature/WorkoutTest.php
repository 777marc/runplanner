<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Workout;
use App\Models\WorkoutType;
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

    /** @test */
    public function a_logged_in_user_can_get_workouts()
    {
        $user = User::factory()->create();
        $workoutType = WorkoutType::factory()->create();
        $workout = Workout::factory(["workout_type_id" => $workoutType->id])->create();
        $baseUrl = env('APP_URL') . '/api/workouts';
    
        $this->actingAs($user);

        $response = $this->json('GET', $baseUrl . '/');
        $this->assertEquals($workout["name"], $response["data"][0]["name"]);

        $response->assertStatus(200);

    }

    /** @test */
    public function a_logged_in_user_cant_see_others_workouts()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $workoutType = WorkoutType::factory()->create();
        $workout = Workout::factory([
            "workout_type_id" => $workoutType->id,
            "user_id" => $otherUser->id,
        ])->create();
        $baseUrl = env('APP_URL') . '/api/workouts';
    
        $this->actingAs($user);

        $response = $this->json('GET', $baseUrl . '/');
        $response->assertStatus(200);
        $this->assertEquals(0, count($response["data"]));
    }

    /** @test */
    public function a_logged_in_user_can_get_a_single_workout()
    {
        $user = User::factory()->create();
        $workoutType = WorkoutType::factory()->create();
        $workout = Workout::factory(["workout_type_id" => $workoutType->id])->create();
        $baseUrl = env('APP_URL') . '/api/workouts';

        $this->actingAs($user);

        $response = $this->json('GET', $baseUrl . '/' . $workout->id);
        $this->assertEquals($workout["name"], $response["data"]["name"]);

        $response->assertStatus(200);

    }

    /** @test */
    public function a_logged_in_user_cant_see_others_single_workout()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $workoutType = WorkoutType::factory()->create();
        $workout = Workout::factory([
            "workout_type_id" => $workoutType->id,
            "user_id" => $otherUser->id,
        ])->create();
        $baseUrl = env('APP_URL') . '/api/workouts/' . $workout->id;

        $this->actingAs($user);

        $response = $this->json('GET', $baseUrl);
        $this->assertEquals(0, count($response["data"]));
        $response->assertStatus(200);

    }

    private function calculatePace($distance, $duration)
    {
        return ($duration / 60) / $distance;
    }
}
