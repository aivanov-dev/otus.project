<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="SkillResource",
 *     description="Skill resource",
 *     @OA\Xml(
 *         name="SkillResource"
 *     ),
 *
 *     @OA\Property(
 *          property="id",
 *          title="id",
 *          example="3"
 *     ),
 *
 *      @OA\Property(
 *          property="name",
 *          title="name",
 *          example="Чтение"
 *      ),
 *
 *      @OA\Property(
 *          property="code",
 *          title="code",
 *          example="reading"
 *      )
 * )
 */
class SkillResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code
        ];
    }
}
