<?php

namespace App\Models;

use App\Enums\NotificationStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_id',
        'mass_notification_id',
        'notification_type_id',
        'channel',
        'message',
        'retry_count',
        'original_id',
        'current_status_id'
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function type()
    {
        return $this->belongsTo(
            NotificationType::class,
            'notification_type_id'
        );
    }

    public function currentStatus()
    {
        return $this->belongsTo(
            NotificationStatus::class,
            'current_status_id'
        );
    }

    public function statuses()
    {
        return $this->hasMany(
            NotificationStatusHistory::class
        );
    }

    public function changeStatus(NotificationStatusEnum $status): void 
    {
        $this->update(['current_status_id' => $status->value]);

        $this->statuses()->create(['notification_status_id' => $status->value]);
    }

    protected static function booted(): void
    {
        static::created(function (Notification $notification) {

            NotificationStatusHistory::create([
                'notification_id' => $notification->id,
                'notification_status_id' => NotificationStatusEnum::IN_QUEUE->value,
            ]);
        });
    }
}
