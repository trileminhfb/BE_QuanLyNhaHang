<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules()
    {
        return [
            'id_table' => 'required|exists:tables,id',
            'timeEnd' => 'required|date',
            'total' => 'required|numeric',
            'id_user' => 'required|exists:users,id',
            'id_customer' => 'required|exists:customers,id',
        ];
    }
    public function messages(): array
    {
        return [
            'id_booking.required' => 'Vui lòng chọn mã đặt bàn.',
            'id_booking.exists' => 'Mã đặt bàn không tồn tại.',

            'timeEnd.required' => 'Vui lòng nhập thời gian kết thúc.',
            'timeEnd.date' => 'Thời gian kết thúc không đúng định dạng.',

            'total.required' => 'Vui lòng nhập tổng tiền.',
            'total.integer' => 'Tổng tiền phải là số nguyên.',
            'total.min' => 'Tổng tiền không được nhỏ hơn 0.',

            'id_user.required' => 'Vui lòng chọn nhân viên lập hóa đơn.',
            'id_user.integer' => 'ID nhân viên phải là số nguyên.',
        ];
    }
}
