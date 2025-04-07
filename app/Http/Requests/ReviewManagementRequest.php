<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewManagementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_rate'   => 'required|integer|exists:rates,id',
            'id_user'   => 'required|integer|exists:users,id',
            'comment'   => 'required|min:5|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'id_rate.required'   => 'Mã đánh giá là bắt buộc.',
            'id_rate.integer'    => 'Mã đánh giá phải là số nguyên.',
            'id_rate.exists'     => 'Mã đánh giá không tồn tại trong hệ thống.',

            'id_user.required'   => 'Mã người dùng là bắt buộc.',
            'id_user.integer'    => 'Mã người dùng phải là số nguyên.',
            'id_user.exists'     => 'Mã người dùng không tồn tại trong hệ thống.',

            'comment.required'   => 'Bình luận không được để trống.',
            'comment.min'        => 'Bình luận phải có ít nhất 5 ký tự.',
            'comment.max'        => 'Bình luận không được vượt quá 1000 ký tự.',
        ];
    }
}
