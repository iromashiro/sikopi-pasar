<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLevyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'trader_kiosk_id' => ['required', 'exists:trader_kiosk,id'],
            'period_month'   => ['required', 'digits:6'],
            'due_date'       => ['required', 'date'],
            'amount'         => ['required', 'integer', 'min:1'],
        ];
    }
}
