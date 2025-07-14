<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {


        return [
            'name' => [
                'required',
                'string',
                'max:20',
                Rule::unique('categories', 'name')->ignore($this->route('category')),
            ],
            'status' => ['required', 'in:0,1'],
        ];
    }
}
