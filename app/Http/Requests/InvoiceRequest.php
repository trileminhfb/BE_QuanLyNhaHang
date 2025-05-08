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
            'sale_code' => 'nullable|string|exists:sales,code',
        ];
    }

    public function messages(): array
    {
        return [
            'id_table.required' => 'Vui lòng chọn mã bàn.',
            'id_table.exists' => 'Mã bàn không tồn tại.',

            'sale_code.exists' => 'Mã khuyến mãi không hợp lệ.',
        ];
    }
}
