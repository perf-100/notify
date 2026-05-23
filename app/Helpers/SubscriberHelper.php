<?php

namespace App\Helpers;

use App\Models\Subscriber;

class SubscriberHelper
{
    private int $limit = 20;

    public function paginate()
    {
        $data = Subscriber::query()
            ->with([
                'notifications.type',
                'notifications.currentStatus',
                'notifications.statuses.status',
            ])
            ->latest()
            ->paginate($this->limit);

        return $data;
    }
}