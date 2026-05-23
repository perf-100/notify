<?php

namespace App\Providers;

use App\Interfaces\NotificationProviderInterface;

class MockMailProvider implements NotificationProviderInterface
{
    public function send(string $email, string $message): string 
    {
        sleep(rand(1, 2));

        return (string) str()->uuid();
    }
}