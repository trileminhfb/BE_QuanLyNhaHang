<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'nameRank' => 'required|string|max:255',
            'necessaryPoint' => 'required|integer',
            'saleRank' => 'required|integer',
            'image' => 'nullable|string', // Tùy chọn
        ];
    }

    public function messages(): array
    {
        return [
            'nameRank.required' => 'Vui lòng nhập tên hạng.',
            'nameRank.string' => 'Tên hạng phải là chuỗi ký tự.',
            'nameRank.max' => 'Tên hạng không được vượt quá 255 ký tự.',

            'necessaryPoint.required' => 'Vui lòng nhập điểm cần thiết.',
            'necessaryPoint.integer' => 'Điểm cần thiết phải là số nguyên.',

            'saleRank.required' => 'Vui lòng nhập phần trăm giảm giá.',
            'saleRank.integer' => 'Phần trăm giảm giá phải là số nguyên.',

            'image.string' => 'Đường dẫn hình ảnh phải là chuỗi ký tự.',
        ];
    }
}
