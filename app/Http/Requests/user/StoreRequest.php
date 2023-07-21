<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'name' => 'required|min:6|max:100'
        ];
    }

    // public function messages(): array{
    //     return [
    //         'email.required' => 'Vui lòng nhập Email.',
    //         'email.email' => 'Vui lòng nhập địa chỉ Email hợp lệ.',
    //         'email.unique' => 'Email này đã tồn tại.',
    //         'name.required' => "Vui lòng nhập tên",
    //         'name.min' => "Tên ít nhất là 6 kí tự",
    //         'name.max' => "Tên nhiều nhất là 100 kí tự"
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
