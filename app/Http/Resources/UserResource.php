<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="UserResource",
 *     description="User resource",
 *     @OA\Xml(
 *         name="UserResource"
 *     ),
 *
 *     @OA\Property(
 *          property="id",
 *          title="id",
 *          example=1
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
class UserResource extends JsonResource
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
            'id'   => $this->getKey(),
            'name' => $this->name,
        ];
    }
}
