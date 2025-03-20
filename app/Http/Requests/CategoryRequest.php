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
}
