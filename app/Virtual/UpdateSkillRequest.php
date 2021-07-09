<?php


namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Update skill request",
 *      description="Update skill request body data",
 *      type="object"
 * )
 */
class UpdateSkillRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="New name of the skill",
     *      example="Чтение"
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *      title="code",
     *      description="New code of the skill",
     *      example="reading"
     * )
     *
     * @var string
     */
    public string $code;
}
