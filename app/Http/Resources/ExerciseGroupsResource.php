<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ExerciseGroupsResource",
 *     description="ExerciseGroups resource",
 *     @OA\Xml(
 *         name="ExerciseGroupsResource"
 *     ),
 *
 *     @OA\Property(
 *         property="name",
 *         title="name",
 *         example="John"
 *     ),
 *
 * )
 */
class ExerciseGroupsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    #[ArrayShape(['meta' => "array", 'data' => "\Illuminate\Support\Collection"])]
    public function toArray(
        $request
    ): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '_lft' => $this->_lft,
            '_rgt' => $this->_rgt,
            'parent_id' => $this->parent_id,
        ];
    }
}
