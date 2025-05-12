<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_ingredient' => 'required|string|min:2|max:100|unique:ingredients,name_ingredient',
            'image'           => 'required',
            'unit'            => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name_ingredient.required' => 'Phải nhập tên nguyên liệu.',
            'name_ingredient.string'   => 'Tên nguyên liệu phải là chuỗi.',
            'name_ingredient.min'      => 'Tên nguyên liệu phải có ít nhất 2 ký tự.',
            'name_ingredient.max'      => 'Tên nguyên liệu không được vượt quá 100 ký tự.',
            'name_ingredient.unique'   => 'Tên nguyên liệu đã tồn tại trong hệ thống.',

            'image.required' => 'Phải chọn ảnh nguyên liệu.',
            'image.image'    => 'File tải lên phải là hình ảnh.',
            'image.mimes'    => 'Ảnh phải có định dạng jpg, jpeg hoặc png.',
            'image.max'      => 'Ảnh không được lớn hơn 2MB.',

            'unit.required'  => 'Phải nhập đơn vị cho nguyên liệu.',
            'unit.string'    => 'Đơn vị phải là chuỗi.',
            'unit.max'       => 'Đơn vị không được vượt quá 50 ký tự.',
        ];
    }
}
