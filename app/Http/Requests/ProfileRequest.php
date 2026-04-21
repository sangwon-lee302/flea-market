<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'avatar'      => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'nickname'    => ['required', 'string', 'max:20'],
            'postal_code' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address'     => ['required', 'string', 'max:255'],
            'building'    => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'postal_code.regex' => ':attributeはハイフンを含め、半角数字7桁で入力してください',
        ];
    }
}
