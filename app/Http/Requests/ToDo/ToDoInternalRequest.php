<?php

namespace App\Http\Requests\ToDo;

use Illuminate\Foundation\Http\FormRequest;

class ToDoInternalRequest extends FormRequest
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
            'priority_id' => ['required', 'int'],
            'todo_date' => ['required'],
            'todo_deadline' => ['required'],
            'contact_id' => ['required', 'int'],
            'user_id' => ['required', 'int'],
            'task_id' => ['required', 'int'],
            'status_id' => ['required', 'int'],
            'type_id' => ['required', 'int'],
            'todo_remark' => ['nullable', 'string'],
            'color_id' => ['required', 'int'],
            'source_id' => ['required', 'int'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Please select the user',
            'todo_date.required' => 'The start date is required',
            'todo_deadline.required' => 'The end date is required',
            'status_id.required' => 'Please select the contact status',
            'contact_id.required' => 'Please select the contact name',
            'type_id.required' => 'Please select the contact type',
            'task_id.required' => 'Please select the task',
        ];
    }
}
