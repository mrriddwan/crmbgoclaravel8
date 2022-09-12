<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FollowUpResource extends JsonResource
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
            'id' => $this->id,
            'followup_created' => $this->followup_created,
            'followup_time' => $this->followup_time,
            'followup_remark' => substr($this->followup_remark, 0, 20) . '...',
            'contact' => $this->contact->only('id', 'name'),
            'user' => $this->user->only('id', 'name'),
            'task' => $this->task->only('id', 'name'),
            'status' => $this->status->only('id', 'name'),
            'type' => $this->type->only('id', 'name'),
            'priority' => $this->priority->only('id', 'name'),
            
        ];
    }
}
