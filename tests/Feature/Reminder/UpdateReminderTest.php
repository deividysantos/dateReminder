<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateReminderTest extends TestCase
{

    use refreshdatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_be_able_make_update()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Reminder::query()->create([
            'friend_name' => 'laravel',
            'date' => '27/08/2001',
            'user_id' => '1'
        ]);

        $payload = [
            'friend_name' => 'test',
            'date' => '27/08/2001'
        ];

        $response = $this->withHeader('Accept', 'application/json')
            ->put(Route('updateReminder', 1), $payload);

        $response->assertStatus(200);
        $response->assertExactJson([
           'message' => 'success',
           'data' => [
               'friend_name' => 'test',
               'date' => '27/08/2001'
           ]
        ]);

        $this->assertDatabaseHas('reminders',[
            'friend_name' => 'test',
            'date' => '27/08/2001',
            'user_id' => 1
        ]);
    }

    public function test_should_not_be_able_a_remainder_be_updated_by_other_user()
    {
        $user = User::factory(2)->create();

        $this->actingAs($user[0]);

        Reminder::query()->create([
            'friend_name' => 'laravel',
            'date' => '27/08/2001',
            'user_id' => '2'
        ]);

        $payload = [
            'friend_name' => 'test',
            'date' => '27/08/2001'
        ];

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->put(Route('updateReminder', 1), $payload);

        $response->assertStatus(403);
        $response->assertExactJson([
            'error' => 'This resource does not belongs for this user.'
        ]);

        $this->assertDatabaseHas('reminders',[
            'friend_name' => 'laravel',
            'date' => '27/08/2001',
            'user_id' => 2
        ]);
    }
}
