<?php

namespace App\Http\Resources\Billboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TempboardResource extends JsonResource
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
            'tpboard_entrydate' => $this -> tpboard_entrydate,
            'tpboard_startdate' => $this -> tpboard_startdate,
            'tpboard_enddate' => $this -> tpboard_enddate,
            'tpboard_size' => $this -> tpboard_size,
            'tpboard_location' => $this -> tpboard_location,
            'tpboard_unit' => $this -> tpboard_unit,
            'tpboard_collection' => $this -> tpboard_collection,
            'tpboard_material' => $this -> tpboard_material,
            'tpboard_printing' => $this -> tpboard_printing,
            'tpboard_installation' => $this -> tpboard_installation,
            'tpboard_remark' => $this -> tpboard_remark,
            'contact_id' => $this -> contact["id"],
            'contact_name' => $this -> contact["name"],
            'user_id' => $this -> user["id"],
            'user_name' => $this -> user["name"],
        ];
    }
}
