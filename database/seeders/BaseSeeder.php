<?php

namespace Database\Seeders;

use App\Models\NotificationStatus;
use App\Models\NotificationType;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationStatus::insert([
            [
                'id' => 1,
                'name' => 'in_queue',
            ],
            [
                'id' => 2,
                'name' => 'sent',
            ],
            [
                'id' => 3,
                'name' => 'delivered',
            ],
            [
                'id' => 4,
                'name' => 'discarded',
            ],
        ]);

        NotificationType::insert([
            [
                'id' => 1,
                'name' => 'marketing',
                'priority' => false,
            ],
            [
                'id' => 2,
                'name' => 'codes',
                'priority' => true,
            ],
        ]);
        
        Subscriber::insert([
            [
                'email' => 'test1@mail.ru',
                'phone' => '79894561231',
            ],
            [
                'email' => 'test2@yandex.ru',
                'phone' => '79874566554',
            ],
            [
                'email' => 'test3@gmail.com',
                'phone' => '79853216547',
            ]
        ]);
    }
}
