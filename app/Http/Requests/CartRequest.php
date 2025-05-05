<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_food'  => 'required|integer|exists:foods,id',
            'id_table' => 'required|integer|exists:tables,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'id_food.required'  => 'Món ăn là bắt buộc.',
            'id_food.integer'   => 'ID món ăn phải là số nguyên.',
            'id_food.exists'    => 'Món ăn không tồn tại.',
            'id_table.required' => 'Bàn là bắt buộc.',
            'id_table.integer'  => 'ID bàn phải là số nguyên.',
            'id_table.exists'   => 'Bàn không tồn tại.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer'  => 'Số lượng phải là số nguyên.',
            'quantity.min'      => 'Số lượng tối thiểu là 1.',
        ];
    }
}
