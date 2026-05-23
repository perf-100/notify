<?php

namespace App\Helpers;

use App\Models\MassNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class MassNotificationHelper
{
    private int $limit = 20;

    public function __construct(private NotificationHelper $notificationHelper) 
    {

    }

    public function paginate()
    {
        return MassNotification::query()
            ->withCount('notifications')
            ->latest()
            ->paginate($this->limit);
    }

    public function create(array $data): MassNotification
    {
        $key = $data['idempotency_key'];

        $lock = Cache::lock("idempotency:{$key}", 30);

        if (!$lock->get()) {
            throw ValidationException::withMessages([
                'idempotency_key' => 'Duplicate request',
            ]);
        }

        try {
            return DB::transaction(
                function () use ($data) {

                    $massnotification = MassNotification::create([
                        'name' => $data['name'],
                        'idempotency_key' => $data['idempotency_key'],
                    ]);

                    foreach ($data['subscriber_ids'] as $subscriberId) {
                        $this->notificationHelper->create([
                            'subscriber_id' => $subscriberId,
                            'mass_notification_id' => $massnotification->id,
                            'notification_type_id' => $data['notification_type_id'],
                            'channel' => $data['channel'],
                            'message' => $data['message'],
                        ]);
                    }

                    return $massnotification;
                }
            );

        } finally {
            $lock->release();
        }
    }
}