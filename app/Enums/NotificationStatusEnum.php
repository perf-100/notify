<?php

namespace App\Enums;

enum NotificationStatusEnum: int
{
    case IN_QUEUE = 1;

    case SENT = 2;

    case DELIVERED = 3;

    case DISCARDED = 4;
}