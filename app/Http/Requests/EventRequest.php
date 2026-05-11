<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'event_type' => ['required', 'string', 'max:100'],
            'event_date' => ['required', 'date'],
            'venue' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:planned,completed,cancelled'],
            'user_ids' => ['nullable', 'array'],
            'user_ids.*' => ['exists:users,id'],
            'user_roles' => ['nullable', 'array'],
            'user_roles.*' => ['in:photographer,editor'],
        ];
    }
}
