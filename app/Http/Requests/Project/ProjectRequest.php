<?php

namespace App\Http\Requests\Project;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'project_startdate' => ['required','after:'. Carbon::yesterday()->format('d-m-Y')],
            'project_enddate' => ['required', 'date'],
            'project_name' => ['required', 'string'],
            'project_remark' => ['required', 'string'],
            'contact_id' => ['required', 'int'],
            'user_id' => ['required', 'int'],
        ];
    }

    public function messages()
    {
        return [
            'project_startdate.required' => 'The start date is required',
            'project_startdate.after' => 'The project minimum date is today.',
            'project_enddate.required' => 'The end date is required',
            'project_name.required' => 'The project name is required',
            'contact_id.required' => 'Please select the contact name',
        ];
    }
}
