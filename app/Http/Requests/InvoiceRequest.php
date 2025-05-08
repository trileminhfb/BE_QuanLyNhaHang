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
            'total' => 'required|numeric|min:0',  // đã sửa thành numeric và thêm min:0
            'id_user' => 'required|exists:users,id',
            'id_customer' => 'required|exists:customers,id',
            'id_sale' => 'required|exists:sales,id',  // thêm rule cho id_sale nếu cần
        ];
    }

    public function messages(): array
    {
        return [
            'id_table.required' => 'Vui lòng chọn mã bàn.',
            'id_table.exists' => 'Mã bàn không tồn tại.',

            'timeEnd.required' => 'Vui lòng nhập thời gian kết thúc.',
            'timeEnd.date' => 'Thời gian kết thúc không đúng định dạng.',

            'total.required' => 'Vui lòng nhập tổng tiền.',
            'total.numeric' => 'Tổng tiền phải là số.',
            'total.min' => 'Tổng tiền không được nhỏ hơn 0.',

            'id_user.required' => 'Vui lòng chọn nhân viên lập hóa đơn.',
            'id_user.exists' => 'ID nhân viên không tồn tại.',

            'id_customer.required' => 'Vui lòng chọn khách hàng.',
            'id_customer.exists' => 'ID khách hàng không tồn tại.',

            'id_sale.required' => 'Vui lòng chọn nhân viên bán hàng.',
            'id_sale.exists' => 'ID nhân viên bán hàng không tồn tại.',  // thêm thông báo lỗi cho id_sale
        ];
    }
}
