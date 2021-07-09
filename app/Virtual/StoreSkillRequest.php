<?php


namespace App\Virtual;


/**
 * @OA\Schema(
 *      title="Store skill request",
 *      description="Store skill request body data",
 *      type="object",
 *      required={"name", "code"}
 * )
 */
class StoreSkillRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new skill",
     *      example="Чтение"
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *      title="code",
     *      description="Code of the new skill",
     *      example="reading"
     * )
     *
     * @var string
     */
    public string $code;
}
