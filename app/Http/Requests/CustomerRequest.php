<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Xác thực người dùng có quyền gửi request hay không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Quy tắc validation.
     */
    public function rules(): array
    {
        return [
            'phoneNumber' => 'required|string|unique:customers,phoneNumber',
            'FullName' => 'required|string|max:255',
            'otp' => 'nullable|string|min:4|max:6',
            'point' => 'nullable|integer|min:0',
            'id_rank' => 'required|exists:ranks,id',
            'mail' => 'nullable|email|max:255',
            'birth' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Thông báo lỗi tiếng Việt.
     */
    public function messages(): array
    {
        return [
            'phoneNumber.required' => 'Vui lòng nhập số điện thoại.',
            'phoneNumber.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phoneNumber.unique' => 'Số điện thoại đã tồn tại.',

            'FullName.required' => 'Vui lòng nhập họ tên.',
            'FullName.string' => 'Họ tên phải là chuỗi ký tự.',
            'FullName.max' => 'Họ tên không được vượt quá 255 ký tự.',

            'otp.string' => 'Mã OTP phải là chuỗi ký tự.',
            'otp.min' => 'Mã OTP phải có ít nhất 4 ký tự.',
            'otp.max' => 'Mã OTP không được vượt quá 6 ký tự.',

            'point.integer' => 'Điểm phải là số nguyên.',
            'point.min' => 'Điểm không được nhỏ hơn 0.',

            'id_rank.required' => 'Vui lòng chọn hạng thành viên.',
            'id_rank.exists' => 'Hạng thành viên không tồn tại.',

            'mail.email' => 'Email không đúng định dạng.',
            'mail.max' => 'Email không được vượt quá 255 ký tự.',

            'birth.date' => 'Ngày sinh không hợp lệ.',

            'image.image' => 'Tệp tải lên phải là ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            'image.max' => 'Ảnh không được lớn hơn 2MB.',
        ];
    }
}
