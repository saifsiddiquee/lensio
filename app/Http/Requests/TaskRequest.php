<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'event_id' => ['required', 'exists:events,id'],
            'title' => ['required', 'string', 'max:150'],
            'task_type' => ['required', 'in:pre_event,event_day,post_event'],
            'assigned_to' => ['required', 'exists:users,id'],
            'due_date' => ['nullable', 'date'],
            'status' => ['required', 'in:pending,in_progress,done'],
        ];
    }
}
