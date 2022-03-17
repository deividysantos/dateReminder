<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadReminderControllerTest extends TestCase
{

    use refreshdatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_be_able_read_reminders()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Reminder::query()->create([
            'friend_name' => 'test',
            'date' => '27/08/2001',
            'user_id' => 1
        ]);

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->get(Route('readReminders'));

        $response->assertStatus(200);
        $response->assertExactJson(
            [
                [
                    'friend_name' => 'test',
                    'date' => '27/08/2001'
                ]
            ]
        );
    }

    public function test_should_not_be_able_read_reminders_by_other_user()
    {
        $user = User::factory(2)->create();
        $this->actingAs($user[1]);

        Reminder::query()->create([
            'friend_name' => 'test',
            'date' => '27/08/2001',
            'user_id' => 1
        ]);

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->get(Route('readReminder', 1));

        $response->assertStatus(403);
    }
}
