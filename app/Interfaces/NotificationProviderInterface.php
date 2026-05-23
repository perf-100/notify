<?php

namespace App\Interfaces;

interface NotificationProviderInterface
{
    public function send(string $recipient, string $message): string;
}