<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'side_name'=>['required','string'],
            'logo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'facebook'=>['required','url'],
            'instagram'=>['required','url'],
            'linkedin'=>['required','url'],
            'youtube'=>['required','url'],
            'twitter'=>['required','url'],
            'email'=>['required'],
            'street'=>['required'],
            'city'=>['required'],
            'country'=>['required'],
            'phone'=>  ['required', 'regex:/^\+?[0-9\s\-\(\)]+$/'], // this validation in Backend level
        ];
    }
}
