<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKioskRequest extends StoreKioskRequest
{
    public function rules(): array
    {
        $market = $this->market_id ?? $this->route('kiosk')->market_id;
        $id     = $this->route('kiosk')->id;

        return [
            'market_id' => ['required', 'exists:markets,id'],
            'kiosk_no' => [
                'required',
                'string',
                'max:30',
                "unique:kiosks,kiosk_no,{$id},id,market_id,{$market}"
            ],
            'category' => ['required', 'string', 'max:50'],
            'area_m2'  => ['required', 'numeric', 'min:1', 'max:9999'],
            'status'   => ['required', 'in:available,occupied,inactive'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'market_id' => (int) $this->market_id,
            'kiosk_no'  => trim(strip_tags($this->kiosk_no)),
            'category'  => trim(strip_tags($this->category)),
        ]);
    }
}
