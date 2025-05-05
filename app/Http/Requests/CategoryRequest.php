<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|integer|in:0,1', // 0 = Inactive, 1 = Active
            'name' => 'required|string|unique:categorys,name|max:255',
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
        ];
    }
}
