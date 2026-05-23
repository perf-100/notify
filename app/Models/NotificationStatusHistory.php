<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'notification_status_history';

    protected $fillable = [
        'notification_id',
        'notification_status_id',
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    public function status()
    {
        return $this->belongsTo(
            NotificationStatus::class,
            'notification_status_id'
        );
    }
}
