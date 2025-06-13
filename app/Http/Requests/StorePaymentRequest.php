<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'levy_id'        => ['required', 'exists:levies,id'],
            'paid_at'        => ['required', 'date'],
            'amount'         => ['required', 'integer', 'min:1'],
            'method'         => ['nullable', 'string', 'max:30'],
            'collector_name' => ['nullable', 'string', 'max:100'],
        ];
    }
}
