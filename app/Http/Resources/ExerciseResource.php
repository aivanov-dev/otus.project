<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ExerciseResource",
 *     description="Exercise resource",
 *     @OA\Xml(
 *         name="ExerciseResource"
 *     ),
 *
 *     @OA\Property(
 *         property="name",
 *         title="name",
 *         example="Ex. #3y7-2y3"
 *     ),
 *
 * )
 */
class ExerciseResource extends JsonResource
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
            'name' => $this->name,
        ];
    }
}
