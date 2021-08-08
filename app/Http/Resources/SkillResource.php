<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

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
     * @param Request $request
     * @return array
     */
    #[ArrayShape(['id' => "int", 'name' => "string", 'code' => "string"])]
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'code' => $this->code
        ];
    }
}
