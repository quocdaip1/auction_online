<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

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
            
            'email' => 'required|email',
            'password' => 'required|min:6',           
        ];
    }

    public function messages(): array {
        return [
            'email.required' => 'Vui lòng nhập Email.',
            'email.email' => 'Vui lòng nhập địa chỉ Email hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ];
    }
}
