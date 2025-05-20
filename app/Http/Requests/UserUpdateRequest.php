<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image'          => 'nullable',
            'name'           => 'required|string|min:3|max:100',
            'role'           => 'required|string|in:admin,manager,staff',
            'phone_number'   => 'required|string|regex:/^0[0-9]{9}$/|unique:users,phone_number,' . $this->route('id'),
            'email'          => 'required|email|unique:users,email,' . $this->route('id'),
            'status'         => 'required|in:active,inactive,banned',
            'birth'          => 'required|date|before:today',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'Tên là bắt buộc.',
            'name.min'               => 'Tên phải có ít nhất 3 ký tự.',
            'name.max'               => 'Tên không được vượt quá 100 ký tự.',

            'role.required'          => 'Vai trò là bắt buộc.',
            'role.in'                => 'Vai trò không hợp lệ. Chỉ chấp nhận: admin, user, staff.',

            'phone_number.required'  => 'Số điện thoại là bắt buộc.',
            'phone_number.regex'     => 'Số điện thoại không hợp lệ.',
            'phone_number.unique'    => 'Số điện thoại đã tồn tại.',

            'email.required'         => 'Email là bắt buộc.',
            'email.email'            => 'Email không đúng định dạng.',
            'email.unique'           => 'Email đã tồn tại.',

            'status.required'        => 'Trạng thái là bắt buộc.',
            'status.in'              => 'Trạng thái phải là active, inactive hoặc banned.',

            'birth.required'         => 'Ngày sinh là bắt buộc.',
            'birth.date'             => 'Ngày sinh không hợp lệ.',
            'birth.before'           => 'Ngày sinh phải trước ngày hiện tại.',

        ];
    }
}
