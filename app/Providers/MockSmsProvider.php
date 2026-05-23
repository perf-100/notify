<?php

namespace App\Providers;

use App\Interfaces\NotificationProviderInterface;

class MockSmsProvider implements NotificationProviderInterface 
{
    public function send(string $phone, string $message): string 
    {
        sleep(rand(1, 3));

        return (string) str()->uuid();
    }
}