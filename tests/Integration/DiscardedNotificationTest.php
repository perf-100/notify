<?php

namespace Tests\Integration;

use App\Enums\NotificationStatusEnum;
use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class DiscardedNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    
    public function test_notification_marked_as_discarded(): void
    {
        $notification = Notification::factory()->create();

        $job = new SendNotificationJob($notification->id);

        $job->failed();

        $this->assertDatabaseHas(
            'notification_status_history',
            [
                'notification_id' => $notification->id,
                'notification_status_id' =>
                    NotificationStatusEnum::DISCARDED->value,
            ]
        );
    }
}