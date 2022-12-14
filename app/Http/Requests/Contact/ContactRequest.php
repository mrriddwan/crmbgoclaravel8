<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            
            'name' => ['required', 'string', 'unique:contacts'],
            'address' => ['nullable', 'string'],
            'industry_id' =>  ['required', 'int'],
            'status_id' =>  ['required', 'int'],
            'type_id' =>  ['required', 'int'],
            'category_id' =>  ['required', 'int'],
            'user_id' =>  ['required'],
            'remark' =>  ['nullable', 'string'],
        ];
    }
}
