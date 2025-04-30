<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_ingredient' => 'required|string|min:2|max:100|unique:ingredients,name_ingredient',
        ];
    }

    public function messages(): array
    {
        return [
            'name_ingredient.required' => 'Tên nguyên liệu là bắt buộc.',
            'name_ingredient.string'   => 'Tên nguyên liệu phải là chuỗi.',
            'name_ingredient.min'      => 'Tên nguyên liệu phải có ít nhất 2 ký tự.',
            'name_ingredient.max'      => 'Tên nguyên liệu không được vượt quá 100 ký tự.',
            'name_ingredient.unique'   => 'Tên nguyên liệu đã tồn tại trong hệ thống.',
        ];
    }
}
