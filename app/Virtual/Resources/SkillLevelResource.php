<?php


namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="SkillLevelResource",
 *     description="Skill level resource",
 *     @OA\Xml(
 *         name="SkillLevelResource"
 *     )
 * )
 */
class SkillLevelResource
{
    /**
     * @OA\Property(
     *     title="name",
     *     example="A1 - Beginner"
     * )
     *
     * @var string $name
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="level",
     *     example="100"
     * )
     *
     * @var int $level
     */
    public int $level;
}
