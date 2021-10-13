<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="TaskResultStatisticsResource",
 *     description="TaskResultStatistics resource",
 *     @OA\Xml(
 *         name="TaskResultStatisticsResource"
 *     ),
 *
 *     @OA\Property(
 *         property="task_id",
 *         title="task_id",
 *         example="45"
 *     ),
 *     @OA\Property(
 *         property="assessment",
 *         title="assessment",
 *         example="8"
 *     ),
 *
 * )
 */
class TaskResultStatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'assessment' => $this->assessment,
        ];
    }
}

