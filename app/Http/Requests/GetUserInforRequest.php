<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetUserInforRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image'         => 'nullable|string|max:255',
            'name'          => 'required|string|max:255',
            'phone_number'  => 'required|string|regex:/^0[0-9]{9}$/|unique:users,phone_number,' . ($this->route('user') ?? '0'),
            'birth'         => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Tên không được để trống.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.regex'    => 'Số điện thoại không hợp lệ.',
            'phone_number.unique'   => 'Số điện thoại đã tồn tại.',
            'image.max'             => 'Đường dẫn ảnh quá dài.',
            'birth.date'            => 'Ngày sinh không đúng định dạng.',
        ];
    }
}
