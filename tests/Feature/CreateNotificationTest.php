<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    
    public function test_can_create_notification(): void
    {
        $response = $this->postJson('/api/notifications', [
            'subscriber_id' => 1,
            'notification_type_id' => 1,
            'channel' => 'sms',
            'message' => 'test',
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('notifications', [
            'channel' => 'sms',
            'message' => 'test',
        ]);

        $this->assertDatabaseHas(
            'notification_status_history',
            [
                'notification_id' => 1,
                'notification_status_id' => 1,
            ]
        );
    }
}