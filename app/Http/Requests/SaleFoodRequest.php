<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleFoodRequest extends FormRequest
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
            'id_food' => 'required|exists:foods,id',
            'id_sale' => 'required|exists:sales,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id_food.required' => 'Món ăn là bắt buộc.',
            'id_sale.required' => 'Chương trình khuyến mãi là bắt buộc.',
            'id_food.exists' => 'Món ăn không tồn tại.',
            'id_sale.exists' => 'Chương trình khuyến mãi không tồn tại.',
        ];
    }
}
