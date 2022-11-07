<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'project_startdate' => $this -> project_startdate,
            'project_enddate' => $this -> project_enddate,
            'project_name' => $this -> project_name,
            'project_remark' => substr($this->project_remark, 0, 20) . '...',
            'user' => $this-> user -> only('id', 'name'),
            'contact' => $this -> contact -> only('id', 'name'),
            'updated_at' => $this -> updated_at -> format('d-m-Y')
        ];
    }
}
