<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use refreshdatabase;

    public function test_should_be_able_make_login()
    {
        User::factory()->create([
            'name' => 'example',
            'email' => 'example@test.com',
            'password' => Hash::make('password')
        ]);

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(Route('login'),
                [
                    'email' => 'example@test.com',
                    'password' => 'password'
                ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'message',
                'token'
            ]
        );

        $this->assertDatabaseCount('personal_access_tokens', 1);
    }

    public function test_should_be_able_make_logout()
    {
        User::factory()->create([
            'name' => 'example',
            'email' => 'example@test.com',
            'password' => Hash::make('password')
        ]);

        $login = $this
            ->post(Route('login'),
                [
                    'email' => 'example@test.com',
                    'password' => 'password'
                ]);

        $this->assertDatabaseCount('personal_access_tokens', 1);

        $response = $this
            ->withHeader('accept', 'application/json')
            ->withHeader('HTTP_Authorization', 'Bearer' . $login->json()['token'])
            ->post(Route('logout'));

        $response->assertStatus(200);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_should_not_be_able_make_login_without_registered_user()
    {

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->post(Route('login'),
                [
                    'email' => 'example@test.com',
                    'password' => 'password'
                ]);

        $response->assertStatus(422);
    }
}
