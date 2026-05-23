<?php

namespace App\Jobs;

use App\Enums\NotificationStatusEnum;
use App\Helpers\NotificationHelper;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public int $notificationId) 
    {

    }

    public function backoff(): array
    {
        return [10, 30, 60];
    }

    public function failed(): void
    {
        Notification::find($this->notificationId)?->changeStatus(NotificationStatusEnum::DISCARDED);
    }

    public function handle(NotificationHelper $helper): void 
    {
        $notification = Notification::findOrFail($this->notificationId);

        if ($notification->original_id) {
            return;
        }

        $notification->increment('retry_count');

        $helper->send($notification);
    }
}
