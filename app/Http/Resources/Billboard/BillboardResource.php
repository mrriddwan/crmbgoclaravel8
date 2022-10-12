<?php

namespace App\Http\Resources\Billboard;

use Illuminate\Http\Resources\Json\JsonResource;

class BillboardResource extends JsonResource
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
            'site_id' => $this -> site_id,
            'billboard_id' => $this -> billboard_id,
            'bboard_location' => substr( $this -> bboard_location, 0 , 10 ) . '...',
            'bboard_size' => $this -> bboard_size,
            'tenure_startdate' => $this -> tenure_startdate,
            'tenure_enddate' => $this -> tenure_enddate,
            'contact_id' => $this -> company_id,
            'contact_name' => $this -> company_name,
        ];
    }
}
