<?php

namespace App\Http\Requests;

use App\Category;
use App\Condition;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
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
            'image'        => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'categories'   => ['required', 'array', 'min:1'],
            'categories.*' => ['required', 'distinct', Rule::enum(Category::class)],
            'condition'    => ['required', Rule::enum(Condition::class)],
            'name'         => ['required', 'string', 'max:255'],
            'brand_name'   => ['nullable', 'string', 'max:255'],
            'description'  => ['required', 'string', 'max:255'],
            'price'        => ['required', 'decimal:0', 'gte:0'],
        ];
    }

    public function attributes()
    {
        return ['name' => '商品名'];
    }

    public function messages()
    {
        return [
            'image.required'      => ':attributeを選択してください',
            'categories.required' => ':attributeを1つ以上選択してください',
            'categories.min'      => ':attributeを1つ以上選択してください',
            'condition.required'  => ':attributeを選択してください',
            'price.decimal'       => ':attributeが無効です',
            'price.gte'           => ':attributeが無効です',
        ];
    }
}
