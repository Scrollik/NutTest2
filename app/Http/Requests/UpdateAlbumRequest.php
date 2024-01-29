<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
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
            'id' => 'required|numeric',
            'name' => 'required|max:100',
            'descr' => 'required|max:100',
            'artist' => 'required|numeric',
            'image' => 'sometimes',
            'new_image' => 'sometimes|mimes:jpeg,jpg,png,bmp,gif,svg',
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
            '*.numeric' => 'Поле может быть только числом',
            '*.max' => 'Поле не может быть больше 100 символов.',
            '*.required' => 'Поле не может быть пустым.',
            'yourImage.mimes' => 'Изображение должно быть в формате:jpeg,jpg,png,bmp,gif,svg.',
        ];
    }
}
