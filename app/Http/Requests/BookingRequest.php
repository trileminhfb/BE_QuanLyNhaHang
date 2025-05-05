<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_table' => 'required|integer|exists:tables,id',
            'timeBooking' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'id_customer' => 'required|exists:customers,id',  // Sửa đúng tên trường là 'id_customer'
        ];
    }

    public function messages(): array
    {
        return [
            'id_table.required' => 'Vui lòng chọn bàn.',
            'id_table.exists' => 'Bàn không tồn tại.',
            'timeBooking.required' => 'Vui lòng chọn thời gian đặt bàn.',
            'timeBooking.date' => 'Thời gian đặt bàn không đúng định dạng.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng tối thiểu là 1.',
            'id_customer.required' => 'Vui lòng chọn khách hàng.',
            'id_customer.exists' => 'Khách hàng không tồn tại.',
        ];
    }
}
