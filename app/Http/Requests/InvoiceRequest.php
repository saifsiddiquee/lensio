<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
        $rules = [
            'event_id' => ['required', 'exists:events,id'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:unpaid,partial,paid'],
        ];

        // For create, invoice_no is required and unique
        // For update, skip unique check for current record
        if ($this->isMethod('POST')) {
            $rules['invoice_no'] = ['required', 'string', 'max:100', 'unique:invoices,invoice_no'];
        } else {
            $rules['invoice_no'] = ['required', 'string', 'max:100', 'unique:invoices,invoice_no,' . $this->route('invoice')->id];
        }

        return $rules;
    }
}
