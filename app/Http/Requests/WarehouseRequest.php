<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_ingredient' => 'required|exists:ingredients,id',
            'quantity'      => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'id_ingredient.required' => 'Nguyên liệu là bắt buộc.',
            'id_ingredient.exists'   => 'Nguyên liệu không tồn tại.',
            'quantity.required'      => 'Số lượng là bắt buộc.',
            'quantity.integer'       => 'Số lượng phải là số nguyên.',
            'quantity.min'           => 'Số lượng không được nhỏ hơn 0.',
        ];
    }
}
