<?php

namespace Tests\Feature\Reminder;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function route;

class CreateReminderTest extends TestCase
{
    use refreshdatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_be_able_make_a_reminder()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $payload = [
            'friend_name' => 'laravel',
            'date' => '27/08/2001'
        ];

        $response = $this
            ->withHeader('Accept', 'Application/json')
            ->post(Route('createReminder'), $payload);

        $response->assertStatus(201);
        $response->assertExactJson([
           'message' => 'success',
           'data' => [
               'friend_name' => 'laravel',
               'date' => '27/08/2001',
               'id' => 1
           ]
        ]);

        $this->assertDatabaseHas('reminders', [
            'user_id' => 1,
            'friend_name' => 'laravel',
            'date' => '27/08/2001',
        ]);
    }

    public function test_should_be_not_able_make_a_reminder_no_user_logged()
    {
        $payload = [
            'friend_name' => 'laravel',
            'date' => '27/08/2001'
        ];

        $response = $this
            ->withHeader('Accept', 'Application/json')
            ->post(Route('createReminder'), $payload);

        $response->assertStatus(401);
        $response->assertExactJson(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount('reminders', 0);
    }


}
