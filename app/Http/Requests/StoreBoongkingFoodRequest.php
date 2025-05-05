<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoongkingFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }
    public function rules()
    {
        return [
            'id_foods' => 'required|integer',
            'quantity' => 'required|integer',
            'id_booking' => 'required|integer',
        ];
    }
    public function messages(): array
    {
        return [
            'id_foods.required' => 'ID thực phẩm là bắt buộc.',
            'id_foods.integer' => 'ID thực phẩm phải là một số nguyên.',
            'id_foods.exists' => 'Thực phẩm không tồn tại.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'id_booking.required' => 'ID đặt món là bắt buộc.',
            'id_booking.integer' => 'ID đặt món phải là một số nguyên.',
            'id_booking.exists' => 'Đặt món không tồn tại.',
        ];
    }
}
