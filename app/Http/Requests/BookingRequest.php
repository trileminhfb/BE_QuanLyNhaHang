<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_table' => 'required|integer',
            'timeBooking' => 'required|date',
            'id_food' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'id_cutomer' => 'required|exists:customers,id',
        ];
    }
}
