<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyShiftRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'shift_date' => 'required|date',
            'shifts'     => 'required|array|min:1',
            'shifts.*.pharmacy_id' => 'required|exists:pharmacies,id',
            'shifts.*.start_time'  => 'required|date_format:H:i',
            'shifts.*.end_time'    => 'required|date_format:H:i|after:shifts.*.start_time',
        ];
    }
}
