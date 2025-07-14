<?php

namespace App\Http\Requests\Admin\Autharization;

use Illuminate\Foundation\Http\FormRequest;

class AutharizeRequest extends FormRequest
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
            'role'=> 'required|min:2|max:250',
            'permissions'=> 'required|array|min:1',
        ];
    }
}
