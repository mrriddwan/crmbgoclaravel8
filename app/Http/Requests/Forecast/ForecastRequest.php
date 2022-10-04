<?php

namespace App\Http\Requests\Forecast;

use Illuminate\Foundation\Http\FormRequest;

class ForecastRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'forecast_date' => ['required', 'date'],
            'forecast_updatedate' => ['nullable', 'date'],
            'amount' => ['required', 'int'],
            'contact_id' => ['required', 'int'],
            'user_id' => ['required', 'int'],
            'forecast_type_id' => ['required', 'int'],
            'product_id' => ['required', 'int'],
        ];
    }

    public function messages()
    {
        return [
            'forecast_date.required' => 'The forecast date is required',
            'product_id.required' => 'The product is required',
            'amount.required' => 'The forecast amount is required',
            'forecast_type_id.required' => 'The forecast type is required',
        ];
    }
}
