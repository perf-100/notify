<?php

namespace App\Helpers;

use App\Enums\NotificationStatusEnum;
use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use App\Providers\MockMailProvider;
use App\Providers\MockSmsProvider;
use Illuminate\Support\Facades\Redis;

class NotificationHelper
{
    private int $limit = 20;

    public function paginate()
    {
        return Notification::query()
            ->with(['subscriber', 'type', 'currentStatus', 'statuses.status'])
            ->latest()
            ->paginate($this->limit);
    }

    public function create(array $data): Notification
    {
        $notification = Notification::create([
            ...$data,
            'current_status_id' => NotificationStatusEnum::IN_QUEUE->value,
        ]);

        $queue = $notification->type->priority ? 'high' : 'default';

        SendNotificationJob::dispatch($notification->id)->onQueue($queue);

        return $notification;
    }

    public function send(Notification $notification): void
    {
        $this->checkRateLimit($notification->channel);

        $provider = match ($notification->channel) {
            'sms' => app(MockSmsProvider::class),
            'email' => app(MockMailProvider::class),
        };

        $recipient = $notification->channel === 'sms'
            ? $notification->subscriber->phone
            : $notification->subscriber->email;

        $externalId = $provider->send($recipient, $notification->message);

        $notification->changeStatus(NotificationStatusEnum::SENT);

        $notification->update([
            'original_id' => $externalId,
        ]);

        // здесь вебхук от провайдера
        $notification->changeStatus(NotificationStatusEnum::DELIVERED);
    }

    private function checkRateLimit(string $channel): void
    {
        $key = "{$channel}:minute";

        $count = Redis::incr($key);

        if ($count === 1) {
            Redis::expire($key, 60);
        }

        if ($count > 100) {
            throw new \RuntimeException('Rate limit exceeded');
        }
    }
}