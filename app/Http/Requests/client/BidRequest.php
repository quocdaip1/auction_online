<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class BidRequest extends FormRequest
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
            'bid_amount' => 'required|numeric',
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'bid_amount.required' => 'The bid amount is required.',
    //         'bid_amount.numeric' => 'The bid amount must be a numeric value.',
    //     ];
    // }
}