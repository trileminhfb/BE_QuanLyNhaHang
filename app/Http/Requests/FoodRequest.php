<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'id_type'     => 'required|exists:types,id',
            'id_category' => 'required|exists:categories,id',
            'cost'        => 'required|numeric|min:0',
            'detail'      => 'nullable|string',
            'status'      => 'required|boolean',
            'bestSeller'  => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Tên món ăn là bắt buộc.',
            'id_type.required'      => 'Loại món ăn là bắt buộc.',
            'id_type.exists'        => 'Loại món ăn không tồn tại.',
            'id_category.required'  => 'Danh mục món ăn là bắt buộc.',
            'id_category.exists'    => 'Danh mục không tồn tại.',
            'cost.required'         => 'Giá món ăn là bắt buộc.',
            'cost.numeric'          => 'Giá phải là số.',
            'status.required'       => 'Trạng thái là bắt buộc.',
            'status.boolean'        => 'Trạng thái chỉ nhận true/false.',
            'bestSeller.boolean'    => 'Trường bestSeller chỉ nhận true/false.',
        ];
    }
}
