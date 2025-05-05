<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
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
            'number' => 'required|integer|unique:tables,number,' . $this->route('id'),
            'status' => 'required|integer|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'number.required' => 'Số bàn là bắt buộc.',
            'number.integer'  => 'Số bàn phải là số nguyên.',
            'number.unique'   => 'Số bàn này đã tồn tại.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in'       => 'Trạng thái phải là 0 (tắt) hoặc 1 (bật).',
        ];
    }
}
