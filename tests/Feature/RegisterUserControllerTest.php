<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserControllerTest extends TestCase
{

    use refreshdatabase;

    public function test_should_be_able_make_to_register()
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(Route('registerUser'),
                [
                    'name' => 'test',
                    'email' => 'test@example.com',
                    'password' => 'password',
                ]);

        $response->assertStatus(201);
        $response->assertExactJson([
            'message' => 'success',
            'data' => [
                'name' => 'test',
                'email' => 'test@example.com',
                'id' => 1
            ]
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_should_not_be_able_register_with_invalid_email()
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(Route('registerUser'),
                [

                    'name' => 'test',
                    'email' => 'test_example.com',
                    'password' => 'password',
                ]);

        $response->assertStatus(422);
        $response->assertExactJson([
            'message' => 'The email must be a valid email address.',
            'errors' => [
                'email' => ['The email must be a valid email address.'],
            ]
        ]);
    }

    public function test_should_not_be_able_register_with_small_password()
    {
        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(Route('registerUser'),
                [
                    'name' => 'test',
                    'email' => 'test@example.com',
                    'password' => 'pass',
                ]);

        $response->assertStatus(422);
        $response->assertExactJson([
            'message' => 'The password must be at least 8 characters.',
            'errors' => [
                'password' => ['The password must be at least 8 characters.'],
            ]
        ]);
    }
}
