<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="TaskResource",
 *     description="Task resource",
 *     @OA\Xml(
 *         name="TaskResource"
 *     ),
 *
 *     @OA\Property(
 *         property="title",
 *         title="title",
 *         example="Task. #3l7-5g5"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         title="description",
 *         example="Esse non nam voluptatibus beatae"
 *     ),
 *
 * )
 */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'exercise_id' => $this->exercise_id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
