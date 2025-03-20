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
            'std' => 'required|string|unique:customers,std',
            'FullName' => 'required|string|max:255',
            'otp' => 'required|string|min:4|max:6',
            'point' => 'integer|min:0',
            'id_rank' => 'required|exists:ranks,id',
        ];
    }
}
