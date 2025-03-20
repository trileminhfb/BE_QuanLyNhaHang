<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nameRank' => 'required|string|unique:ranks,nameRank',
            'necessaryPoint' => 'required|integer|min:0',
            'saleRank' => 'required|integer|min:0|max:100',
        ];
    }
}
