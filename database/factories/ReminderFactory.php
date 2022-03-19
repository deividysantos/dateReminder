<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reminder>
 */
class ReminderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'friend_name' => $this->faker->name(),
            'date' => $this->faker->dateTimeBetween('-30 years' ,'now'),
            'user_id' => User::factory()
        ];
    }
}
