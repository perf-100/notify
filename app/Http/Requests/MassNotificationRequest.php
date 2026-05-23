<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MassNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'idempotency_key' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'notification_type_id' => ['required', 'exists:notification_types,id'],
            'channel' => ['required', 'in:sms,email'],
            'message' => ['required', 'string'],
            'subscriber_ids' => ['required', 'array', 'min:1'],
            'subscriber_ids.*' => ['integer', 'exists:subscribers,id'],
        ];
    }
}