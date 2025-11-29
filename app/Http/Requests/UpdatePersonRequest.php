<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('person')->id ?? $this->route('person');

        return [
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:people,cpf, {$id}',
            'birth_date' => 'required|date',
            'email' => 'required|email|max:255|unique:people,email, {$id}',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
        ];
    }
}
