<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MassNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'idempotency_key' => $this->idempotency_key,
            'notifications_count' => $this->whenCounted('notifications'),
            'created_at' => $this->created_at,
        ];
    }
}
