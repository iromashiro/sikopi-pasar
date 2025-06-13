<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:100', 'unique:markets,name'],
            'location' => ['nullable', 'string', 'max:255'],
            'status'   => ['required', 'in:active,inactive'],
        ];
    }
}
