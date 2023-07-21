<?php

namespace App\Http\Requests\category;

 use Illuminate\Foundation\Http\FormRequest;
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
        $categoryID = $this->route('id');

        return [
            'name' => [
                'required',
                Rule::unique('categories', 'name')->where(function ($query) use ($categoryID) {
                    // Kiểm tra chỉ khi giá trị của 'name' thay đổi hoặc khi tạo mới category
                    $query->where('id', '!=', $categoryID);
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Tên danh mục đã tồn tại'
        ];
    }
}   
