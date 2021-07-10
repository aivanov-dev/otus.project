<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="SkillLevelResource",
 *     description="Skill level resource",
 *     @OA\Xml(
 *         name="SkillLevelResource"
 *     ),
 *
 *     @OA\Property(
 *         property="name",
 *         title="name",
 *         example="A1 - Beginner"
 *     ),
 *
 *     @OA\Property(
 *         property="experience",
 *         title="experience",
 *         type="int",
 *         example="100"
 *     ),
 * )
 */
class SkillLevelResource extends JsonResource
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
            'name' => $this->name,
            'experience' => $this->experience
        ];
    }
}
