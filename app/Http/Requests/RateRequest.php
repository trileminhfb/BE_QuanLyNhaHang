<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_food'      => 'required|integer|min:1|exists:foods,id',
            'id_customer'  => 'required|integer|min:1|exists:customers,id',
            'star'         => 'required|integer|min:1|max:5',
            'detail'       => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'id_food.required'     => 'ID món ăn là bắt buộc.',
            'id_food.integer'      => 'ID món ăn phải là số nguyên.',
            'id_food.min'          => 'ID món ăn không hợp lệ.',
            'id_food.exists'       => 'Món ăn không tồn tại.',

            'id_customer.required' => 'ID khách hàng là bắt buộc.',
            'id_customer.integer'  => 'ID khách hàng phải là số nguyên.',
            'id_customer.min'      => 'ID khách hàng không hợp lệ.',
            'id_customer.exists'   => 'Khách hàng không tồn tại.',

            'star.required'        => 'Số sao đánh giá là bắt buộc.',
            'star.integer'         => 'Số sao phải là số nguyên.',
            'star.min'             => 'Số sao tối thiểu là 1.',
            'star.max'             => 'Số sao tối đa là 5.',

            'detail.string'        => 'Nội dung đánh giá phải là chuỗi.',
            'detail.max'           => 'Chi tiết đánh giá không được vượt quá 1000 ký tự.',

        ];
    }
}
