<?php
declare(strict_types=1);

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="TaskResult",
 *     description="TaskResult model",
 *     @OA\Xml(
 *         name="TaskResult"
 *     )
 * )
 */
class TaskResult
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private int $id;

    /**
     * @OA\Property(
     *      title="TaskId",
     *      description="Id of the task result corresponds to",
     *      format="int64",
     *      example="1"
     * )
     *
     * @var int
     */
    public int $task_id;

    /**
     * @OA\Property(
     *      title="UserId",
     *      description="Id of the user result corresponds to",
     *      format="int64",
     *      example="1"
     * )
     *
     * @var int
     */
    public int $user_id;

    /**
     * @OA\Property(
     *      title="Course or module id",
     *      description="Course or module id",
     *      format="int64",
     *      example="1"
     * )
     *
     * @var int
     */
    public int $exercise_group_id;

    /**
     * @OA\Property(
     *      title="Assessment mark",
     *      description="Assessment mark",
     *      example="10"
     * )
     *
     * @var float
     */
    public float $assessment;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var DateTime
     */
    private DateTime $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var DateTime
     */
    private DateTime $updated_at;
}
