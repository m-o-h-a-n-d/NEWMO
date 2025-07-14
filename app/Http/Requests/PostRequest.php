<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // it should be true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:50'],
            'small_desc'=>['required','min:30','max:150'],
            'description' => ['required', 'string', 'min:10'],
            'category_id' => ['exists:categories,id'],
            'comment_able' => ['in:on,off'], // to choose one value
            'status' => ['nullable','in:1,0'], // to choose one value
            'image' => ['nullable'],
            'image.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // to loop in all images


        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'A title should be More than 3 character',
            'description.required' => 'A description should be more than 10 character',
            'image.*.image'=>'The image should be a Less than 2MB',
            'category_id'=>'The selected category  is invalid.'
        ];
    }
}
