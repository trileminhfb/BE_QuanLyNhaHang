<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_category' => ['required', 'integer', 'min:1'],
            'id_food'     => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_category.required' => 'Vui lòng nhập ID danh mục.',
            'id_category.integer'  => 'ID danh mục phải là số nguyên.',
            'id_category.min'      => 'ID danh mục phải lớn hơn 0.',

            'id_food.required'     => 'Vui lòng nhập ID món ăn.',
            'id_food.integer'      => 'ID món ăn phải là số nguyên.',
            'id_food.min'          => 'ID món ăn phải lớn hơn 0.',
        ];
    }
}
