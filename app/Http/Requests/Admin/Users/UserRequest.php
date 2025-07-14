<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]+$/', 'unique:users,phone'], // this validation in Backend level
            'country' => ['nullable', 'string', 'max:150'],
            'status' => ['in:0,1'],
            'email_verified_at' => ['in:0,1'],
            'city' => ['nullable', 'string', 'max:150'],
            'street' => ['nullable', 'string', 'max:150'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',


        ];
    }
}
