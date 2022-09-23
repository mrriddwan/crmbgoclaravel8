<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'created_at' => $this -> created_at -> format('d-m-Y'),
            'user' => $this-> user -> only('id', 'name'),
            'id' => $this -> id,
            'name' => $this -> name,
            'industry' => $this -> industry,
            'status' => $this -> status -> only('id', 'name'),
            'type' => $this -> type -> only('id', 'name'),
            'category' => $this -> category -> only('id', 'name'),
            'address' => substr( $this -> address, 0 , 10 ) . '...',
            'remark' => substr( $this -> remark, 0 , 20 ) . '...',
        ];
    }
}
