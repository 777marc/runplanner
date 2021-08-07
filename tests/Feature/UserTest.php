<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_login()
    {
        $user = User::factory()->create();
        $baseUrl = env('APP_URL') . '/api/auth/login';
        $email = $user->email;
        $password = "password";
    
        $response = $this->json('POST', $baseUrl . '/', [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
        ]);
    }

    /** @test */
    public function a_user_can_register()
    {
        $baseUrl = env('APP_URL') . '/api/auth/register';

        $newUser = [
            "name" => "marc",
            "email" => "777marc@gmail.com",
            "password" => "marc1111",
            "password_confirmation" => "marc1111"
        ];

        $response = $this->json('POST', $baseUrl . '/', $newUser);
        $response->assertStatus(201);
        $this->assertEquals($newUser["name"], $response["user"]["name"]);
    }

    /** @test */
    public function a_registation_error_is_returned()
    {
        $baseUrl = env('APP_URL') . '/api/auth/register';

        $newUser = [
            "name" => "marc",
            "email" => "777marc@gmail.com",
            "password" => "marc1111"
        ];

        $response = $this->json('POST', $baseUrl . '/', $newUser);
        $response->assertStatus(400);
    }

}
