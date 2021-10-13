<?php

namespace App\Http\Requests\TaskResultStatistics;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Update taskResultStatistics request",
 *      description="Update taskResultStatistics request body data",
 *      type="object",
 *
 *      @OA\Property(
 *         property="task_id",
 *         title="task_id",
 *         example="100"
 *     ),
 *      @OA\Property(
 *         property="assessment",
 *         title="assessment",
 *         example="5"
 *     ),
 * )
 */
class UpdateTaskResultStatisticsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'task_id' => 'numeric|gte:1',
            'assessment' => 'numeric|gte:1|max:10'
        ];
    }
}
