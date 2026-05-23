<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array 
    {
        return [
            'id' => $this->id,
            'channel' => $this->channel,
            'message' => $this->message,
            'retry_count' => $this->retry_count,
            'type' => $this->type?->name,
            'currentStatus' => $this->currentStatus?->name,
            'statuses' => NotificationStatusHistoryResource::collection($this->whenLoaded('statuses')),
            'created_at' => $this->created_at,
        ];
    }
}