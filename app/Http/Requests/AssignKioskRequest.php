<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignKioskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kiosk_id'   => ['required', 'exists:kiosks,id'],
            'start_date' => ['required', 'date', 'before_or_equal:today'],
        ];
    }
}
