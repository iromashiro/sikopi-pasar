<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegenerateLevyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'kiosk_ids' => ['required', 'array'],
            'kiosk_ids.*' => ['exists:kiosks,id'],
            'month'     => ['required', 'digits:6'],
        ];
    }
}
