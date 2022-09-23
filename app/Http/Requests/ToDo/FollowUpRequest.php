<?php

namespace App\Http\Requests\ToDo;

use Illuminate\Foundation\Http\FormRequest;

class FollowUpRequest extends FormRequest
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
            'priority_id' => ['nullable', 'int'],
            'followup_date' => ['required', 'date'],
            'followup_time'=> ['required', 'date_format:H:i:s'],
            'task_id'=> ['required', 'int'],
            'followup_remark'=> ['nullable', 'string'],
            'contact_id' => ['required', 'int'],
            'user_id' => ['required', 'int'],
            'task_id' => ['required', 'int'],
            'status_id' => ['required', 'int'],
            'type_id' => ['required', 'int'],
            'todo_id' => ['required', 'int'],
        ];
    }

    public function messages()
    {
        return [
            'followup_date.required' => 'The start date is required',
            'task_id.required' => 'Please select the task',
        ];
    }
}
