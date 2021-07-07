<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="Store task result request",
 *     description="Store result request body data",
 *     type="object",
 * )
 */
class StoreTaskResultRequest
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
}
