<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
    { // validation rules
        return [
            'name'=>['required','string','min:2','max:50'],
            'email'=>['required','email'],
            'title'=>['required','string','max:60'],
            'body'=>['required','min:8','max:500'],
            'phone'=>['required','regex:/^\+?[0-9\s\-\(\)]+$/'],
            'status'=>['in:1,0']
        ];
    }
}
