<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép mọi người truy cập vào request này
    }

    public function rules(): array
    {
        return [
            'status' => 'required|integer|in:0,1', // 0 = Không hoạt động, 1 = Hoạt động
            'name' => 'required|string|unique:categories,name|max:255',
            'id_type' => 'nullable|integer', // ID loại nếu có
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.integer' => 'Trạng thái phải là số nguyên.',
            'status.in' => 'Trạng thái không hợp lệ. Chỉ chấp nhận 0 (Không hoạt động) hoặc 1 (Hoạt động).',

            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',

            'id_type.integer' => 'ID loại phải là số nguyên hợp lệ.', // Thông báo lỗi cho id_type nếu có
        ];
    }
}
