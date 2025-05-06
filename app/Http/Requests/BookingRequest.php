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
        // Check the request method to handle different validation rules for store and update
        $rules = [
            'id_table' => 'required|integer|exists:tables,id',
            'timeBooking' => 'required|date_format:Y-m-d H:i:s',
            'quantity' => 'required|integer|min:1',
        ];

        if ($this->isMethod('post')) { // Store method validation
            $rules['id_customer'] = 'required|exists:customers,id';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) { // Update method validation
            $rules['id_customer'] = 'nullable|exists:customers,id'; // `id_customer` is optional for update
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'id_table.required' => 'Vui lòng chọn bàn.',
            'id_table.exists' => 'Bàn không tồn tại.',
            'timeBooking.required' => 'Vui lòng chọn thời gian đặt bàn.',
            'timeBooking.date_format' => 'Thời gian đặt bàn không đúng định dạng.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng tối thiểu là 1.',
            'id_customer.required' => 'Vui lòng chọn khách hàng.',
            'id_customer.exists' => 'Khách hàng không tồn tại.',
        ];
    }
}
