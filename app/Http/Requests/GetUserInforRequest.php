<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class GetUserInforRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = Auth::id();
        return [
            'image'         => 'nullable',
            'name'          => 'required|string|max:255',
            'birth'         => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Tên không được để trống.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.regex'    => 'Số điện thoại không hợp lệ.',
            'phone_number.unique'   => 'Số điện thoại đã tồn tại.',
            'birth.date'            => 'Ngày sinh không đúng định dạng.',
        ];
    }
}
