<?php

namespace App\Virtual\Resources;

use App\Models\TaskResult;
use App\Virtual\Models\Meta;

/**
 * @OA\Schema(
 *     title="IndexTaskResultsResource",
 *     description="Task result resource",
 *     @OA\Xml(
 *         name="IndexTaskResultsResource."
 *     )
 * )
 */
class IndexTaskResultsResource
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
     * @var TaskResult[]
     */
    private array $data;
}
