<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_booking' => 'required|exists:bookings,id',
            'timeEnd' => 'required|date',
            'total' => 'required|integer|min:0',
            'id_user' => 'required|integer',
        ];
    }
}
