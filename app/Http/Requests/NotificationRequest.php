<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subscriber_id' => ['required', 'exists:subscribers,id'],
            'notification_type_id' => ['required', 'exists:notification_types,id'],
            'channel' => ['required', 'in:sms,email'],
            'message' => ['required', 'string'],
        ];
    }
}