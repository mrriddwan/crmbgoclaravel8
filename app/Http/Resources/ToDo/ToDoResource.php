<?php

namespace App\Http\Resources\ToDo;

use Illuminate\Http\Resources\Json\JsonResource;

class ToDoResource extends JsonResource
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
            'todo_date' => $this->todo_date,
            'todo_deadline' => $this->todo_deadline,
            'todo_remark' => substr($this->todo_remark, 0, 20) . '...',
            'contact' => $this->contact->only('id', 'name'),
            'user' => $this->user->only('id', 'name'),
            'task' => $this->task->only('id', 'name'),
            'status' => $this->status->only('id', 'name'),
            'type' => $this->type->only('id', 'name'),
            'color' => $this->color->only('id', 'color_code'),
            'action' => $this->action,
            'priority' => $this->priority->only('id', 'name'),
            'source' => $this->source->only('id', 'name'),
            'created_at' => $this->created_at,
            
        ];
    }
}
