<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:people,cpf',
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:people,email',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'uf_id' => 'required|integer',
            'city_id' => 'required|integer',
        ];
    }
}
