<?php
declare(strict_types=1);

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Meta",
 *     description="Meta",
 *     @OA\Xml(
 *         name="Meta"
 *     )
 * )
 */
class Meta
{
    /**
     * @OA\Property(
     *     title="page",
     *     description="page",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $page;

    /**
     * @OA\Property(
     *      title="per-page",
     *      description="Number of entries per page",
     *      example="10"
     * )
     *
     * @var string
     */
    public $perPage;
}
