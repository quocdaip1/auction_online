<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePassWordRequest extends FormRequest
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
            'password' => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'password.min'=> 'Mật khẩu phải có ít nhất 6 kí tự',
    //         'password.max'=> 'Mật khẩu nhiều nhất là 20 kí tự',
    //         'password.confirmed' => 'Mật khẩu không khớp'
    //     ];
    // }
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
