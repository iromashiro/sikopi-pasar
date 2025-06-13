<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKioskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'market_id' => ['required', 'exists:markets,id'],
            'kiosk_no' => ['required', 'string', 'max:30'],
            'category' => ['required', 'string', 'max:50'],
            'area_m2'  => ['required', 'numeric', 'min:1', 'max:9999'],
            'status'   => ['required', 'in:available,occupied,inactive'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['kiosk_no' => trim($this->kiosk_no)]);
    }
}
