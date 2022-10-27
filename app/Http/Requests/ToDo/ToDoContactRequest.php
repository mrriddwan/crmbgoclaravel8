<?php

namespace App\Http\Requests\ToDo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class ToDoContactRequest extends FormRequest
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
            'todo_date' => ['required', 'date',],
            'contact_id'=> ['required', 'int'],
            'user_id' => ['required', 'int'],
            'task_id'=> ['required', 'int'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Please select the user',
            'todo_date.required' => 'The start date is required',
            'contact_id.required' => 'Please select the contact name',
            'task_id.required' => 'Please select the task',
        ];
    }
}
