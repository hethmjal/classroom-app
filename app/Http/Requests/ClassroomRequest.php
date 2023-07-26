<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassroomRequest extends FormRequest
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
            'name' =>['required','string','max:255',function($attribute,$value, $fail){
                if($value == 'test')
                return $fail('the value of name can not be test');
            }],
            'section' =>'string|max:255',
            'subject' =>'string|max:255',
            'room' =>'string|max:255',
            'cover_image' =>[
                'image',
                'max:1024',
              Rule::dimensions([
                'min_width' =>200,
                'min_height'=>200,
              ]),
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'required'=>':attribute is required',
            'section.string'=>'section must be a string',
            'cover_image.max'=>'the image size is great than 1m '
        ];
    }
}
