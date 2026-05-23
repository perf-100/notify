<?php

namespace Tests\Integration;

use App\Enums\NotificationStatusEnum;
use App\Helpers\NotificationHelper;
use App\Models\Notification;
use App\Models\NotificationStatusHistory;
use App\Providers\MockSmsProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class SendNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    
    public function test_notification_is_sent_successfully(): void
    {
        $notification = Notification::factory()->create([
            'channel' => 'sms',
        ]);

        app(NotificationHelper::class)->send($notification->fresh());

        $this->assertDatabaseHas(
            'notifications',
            [
                'id' => $notification->id,
            ]
        );

        $this->assertDatabaseHas(
            'notification_status_history',
            [
                'notification_id' => $notification->id,
                'notification_status_id' => NotificationStatusEnum::SENT->value,
            ]
        );

        $this->assertDatabaseHas(
            'notification_status_history',
            [
                'notification_id' => $notification->id,
                'notification_status_id' => NotificationStatusEnum::DELIVERED->value,
            ]
        );
    }
}