<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarketRequest extends StoreMarketRequest
{
    public function rules(): array
    {
        $id = $this->route('market')->id;
        return [
            'name' => ['required', 'string', 'max:100', "unique:markets,name,{$id}"],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
