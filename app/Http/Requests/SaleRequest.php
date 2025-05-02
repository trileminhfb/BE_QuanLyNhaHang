<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'nameSale' => 'required|string|max:255',
            'status'   => 'required|boolean',
            'startTime'=> 'required|date',
            'endTime'  => 'required|date|after:startTime',
            'percent'  => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nameSale.required' => 'Tên khuyến mãi là bắt buộc.',
            'status.required'   => 'Trạng thái là bắt buộc.',
            'startTime.required'=> 'Thời gian bắt đầu là bắt buộc.',
            'endTime.required'  => 'Thời gian kết thúc là bắt buộc.',
            'percent.required'  => 'Phần trăm giảm giá là bắt buộc.',
        ];
    }
}
