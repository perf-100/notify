<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MassNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'idempotency_key',
    ];

    public function notifications()
    {
        return $this->hasMany(
            Notification::class
        );
    }
}
