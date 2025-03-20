<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryPointRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_customer' => 'required|exists:customers,id',
            'point' => 'integer|min:0',
            'date' => 'required|date',
        ];
    }
}
