<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'event_type' => ['required', 'string', 'max:100'],
            'event_date' => ['nullable', 'date'],
            'source' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:new,contacted,quoted,booked,lost'],
            'assigned_to' => ['required', 'exists:users,id'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
