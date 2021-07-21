<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request;

class TaskResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'user_id' => $this->user_id,
            'exercise_group_id' => $this->exercise_group_id,
            'assessment' => $this->assessment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
