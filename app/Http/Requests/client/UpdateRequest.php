<?php

namespace App\Http\Requests\client;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => 'required|min:6|max:100',
            // 'password' => 'nullable|min:6|max:20|confirmed',
            // 'password_confirmation' => 'nullable',
            // 'oldpassword' => [
            //     'nullable',
            //     function ($attribute, $value, $fail) {
            //         if (!Hash::check($value, $this->user()->password)) {
            //             $fail('The ' . $attribute . ' does not match your current password.');
            //         }
            //     },
            // ],
            'avatar' => 'mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}