<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = auth()->user()->id;

        return [
            'name' => ['required', 'max:255'],

            'username' => [
                'required',
                'max:30',
                Rule::unique('users', 'username')->ignore($userId),
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'phone' => [
                'required',
                'regex:/^\+?[0-9\s\-\(\)]+$/',
                Rule::unique('users', 'phone')->ignore($userId),
            ],

            'country' => ['nullable', 'string', 'max:150'],
            'city' => ['required', 'string', 'max:150'],
            'street' => ['required', 'string', 'max:150'],



            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
