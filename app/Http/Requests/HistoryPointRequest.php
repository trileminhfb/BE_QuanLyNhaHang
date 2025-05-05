<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryPointRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_customer' => 'required|exists:customers,id',
            'point' => 'integer|min:0',
            'date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'id_customer.required' => 'Vui lòng chọn khách hàng.',
            'id_customer.exists' => 'Khách hàng không tồn tại.',

            'point.integer' => 'Điểm phải là số nguyên.',
            'point.min' => 'Điểm không được nhỏ hơn 0.',

            'date.required' => 'Vui lòng nhập ngày.',
            'date.date' => 'Ngày không đúng định dạng.',
        ];
    }
}
