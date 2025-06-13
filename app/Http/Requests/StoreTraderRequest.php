<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NikChecksum;

class StoreTraderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nik'     => ['required', 'digits:16', 'unique:traders,nik', new NikChecksum],
            'name'    => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone'   => ['nullable', 'regex:/^(\+62|62|0)[0-9]{9,13}$/'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['nik' => preg_replace('/\D/', '', $this->nik)]);
    }
}
