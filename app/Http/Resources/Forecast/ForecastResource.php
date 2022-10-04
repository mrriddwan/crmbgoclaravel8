<?php

namespace App\Http\Resources\Forecast;

use Illuminate\Http\Resources\Json\JsonResource;

class ForecastResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this -> id,
            'forecast_updatedate' => $this -> forecast_updatedate,
            'amount' => $this -> amount,
            'forecast_date' => $this->forecast_date,
            'result_id' => $this->result_id,
            'result' => $this-> result,
            'user' => $this-> user -> only('id', 'name'),
            'forecast_type' => $this -> forecast_type -> only('id', 'name'),
            'contact' => $this -> contact -> only('id', 'name'),
            'product' => $this -> product -> only('id', 'name'),
        ];
    }
}
