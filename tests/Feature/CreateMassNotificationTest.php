<?php

namespace Tests\Feature;

use App\Jobs\SendNotificationJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CreateMassNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    
    public function test_mass_notification_creates_jobs()
    {
        Queue::fake();

        $response = $this->postJson(
            '/api/massnotifications',
            [
                'name' => 'test',
                'idempotency_key' => 'abc',
                'notification_type_id' => 1,
                'channel' => 'email',
                'message' => 'hello',
                'subscriber_ids' => [1,2,3],
            ]
        );

        $response->assertCreated();

        Queue::assertPushed(SendNotificationJob::class, 3);
    }
}