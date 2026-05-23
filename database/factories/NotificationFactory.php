<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subscriber_id' => 1,

            'notification_type_id' => 1,

            'channel' => fake()->randomElement([
                'sms',
                'email',
            ]),

            'message' => fake()->sentence(),

            'retry_count' => 0,

            'current_status_id' => 1,

            'original_id' => null,

            'mass_notification_id' => null,
        ];
    }
}
