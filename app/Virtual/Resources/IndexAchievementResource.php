<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\Meta;
use App\Virtual\Models\Achievement;

/**
 * @OA\Schema(
 *     title="IndexAchievementResource",
 *     description="Achievement resource",
 *     @OA\Xml(
 *         name="IndexAchievementResource"
 *     )
 * )
 */
class IndexAchievementResource
{
    /**
     * @OA\Property(
     *     title="Metadata",
     *     description="Metadata"
     * )
     *
     * @var Meta
     */
    private Meta $meta;
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Achievement[]
     */
    private array $data;
}
