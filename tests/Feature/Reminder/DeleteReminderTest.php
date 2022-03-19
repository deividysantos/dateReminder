<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteReminderTest extends TestCase
{

    use refreshdatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_be_able_delete_a_reminder()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Reminder::query()->create([
            'friend_name' => 'laravel',
            'date' => '27/08/2001',
            'user_id' => '1'
        ]);

        $this->assertDatabaseCount('reminders', 1);

        $response = $this
            ->withHeader('Accept','Application/json')
            ->delete(Route('deleteReminder', 1) );

        $response->assertStatus(200);
        $response->assertExactJson([
           'message' => 'success'
        ]);
        $this->assertDatabaseCount('reminders', 0);
    }

    public function test_should_not_be_able_delete_by_other_user()
    {
        $user = User::factory(2)->create();
        $this->actingAs($user[0]);

        Reminder::query()->create([
            'friend_name' => 'laravel',
            'date' => '27/08/2001',
            'user_id' => '2'
        ]);

        $this->assertDatabaseCount('reminders', 1);

        $response = $this
            ->withHeader('Accept','Application/json')
            ->delete(Route('deleteReminder', 1) );

        $response->assertStatus(403);

        $this->assertDatabaseCount('reminders', 1);
    }

}
