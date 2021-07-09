<?php


namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="SkillResource",
 *     description="Skill resource",
 *     @OA\Xml(
 *         name="SkillResource"
 *     )
 * )
 */
class SkillResource
{
    /**
     * @OA\Property(
     *     title="id",
     *     example="3"
     * )
     *
     * @var int $id
     */
    public int $id;

    /**
     * @OA\Property(
     *     title="name",
     *     example="Чтение"
     * )
     *
     * @var string $name
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="code",
     *     example="reading"
     * )
     *
     * @var string $code
     */
    public string $code;
}
