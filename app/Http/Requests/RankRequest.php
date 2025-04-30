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
            'image' => 'nullable|string',  // Optional for the image
        ];
    }
    
}
