<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="Store achievement request",
 *     description="Store achievement request body data",
 *     type="object",
 * )
 */
class StoreAchievementRequest
{
    /**
     * @OA\Property(
     *     title="name",
     *     description="Name of the new achievement",
     *     example="A nice achievement",
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="slug",
     *     description="Slug of the new project",
     *     example="this-is-new-achievement's-slug"
     * )
     *
     * @var string
     */
    public string $slug;

    /**
     * @OA\Property(
     *     title="description",
     *     description="Description of the new achievement",
     *     example="This is new achievement's description"
     * )
     *
     * @var string
     */
    public string $description;

    /**
     * @OA\Property(
     *     title="expression",
     *     description="Expression of the new achievement",
     *     example="exercise.taskResults.countWithCondition('assessment', 10)"
     * )
     *
     * @var string
     */
    public string $expression;
}
