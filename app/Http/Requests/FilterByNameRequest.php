<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterByNameRequest extends FormRequest
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
        return [
            'artist_name' => 'sometimes|max:20|regex:/^[А-Яа-яA-Za-z0-9\s_-]+$/u',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'artist_name.max' => 'Поле не может быть больше 20 символов.',
            'artist_name.required' => 'Поле не может быть пустым.',
//            'artist_name.regex' => 'Недопустимые символы.',
        ];

    }
}
